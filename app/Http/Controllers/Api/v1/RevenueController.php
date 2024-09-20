<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\School;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Log;

class RevenueController extends Controller
{
    public function getTotalRevenue(Request $request)
    {
        // Get total revenue for the school
        $totalRevenue = Revenue::sum('amount');
    
        $revenueByType = [];
    
        // Retrieve revenue records with type, amount, date, and branch, ordered by date
        $revenues = Revenue::with('branch')
                            ->select('type', 'amount', 'date', 'branch_id')
                            ->get();
    
        foreach ($revenues as $revenue) {
            $revenueType = $revenue->type;
            $amount = (float) $revenue->amount;
            $month = date('F', strtotime($revenue->date));
    
            // Safely get the branch name using optional() to prevent errors if branch is null
            $branchName = optional($revenue->branch)->name;
    
            // Group revenue by type and include the branch name
            if (!isset($revenueByType[$revenueType])) {
                $revenueByType[$revenueType] = [];
            }
    
            $revenueByType[$revenueType][] = [
                'month' => $month,
                'amount' => $amount,
                'branch' => $branchName
            ];
        }
    
        $formattedRevenue = [];
        foreach ($revenueByType as $type => $revenueData) {
            $formattedRevenue[$type] = $revenueData;
        }
    
        return response()->json(['revenue' => $formattedRevenue, 'total_revenue' => $totalRevenue]);
    }

    public function getThisYearRevenue(Request $request)
    {
        // Get total revenue for the current year
        $totalRevenue = Revenue::whereYear('date', now()->year)->sum('amount');
        
        return response()->json(['this_year_revenue' => $totalRevenue]);
    }
    public function getThisMonthRevenue(Request $request)
    {
        // Get total revenue for the current month
        $totalRevenue = Revenue::whereMonth('date', now()->month)->sum('amount');
        
        return response()->json(['this_month_revenue' => $totalRevenue]);
    }
    public function getThisWeekRevenue(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get total revenue for the current week
        $totalRevenue = Revenue::whereBetween('date', [$startOfWeek, $endOfWeek])->sum('amount');
        
        return response()->json(['this_week_revenue' => $totalRevenue]);
}
    public function getTodayRevenue(Request $request)
    {
        // Get total revenue for the current month
        $totalRevenue = Revenue::whereDay('date', now()->day)->sum('amount');
        
        return response()->json(['today_revenue' => $totalRevenue]);
    }

    public function getRevenueByMonthYear(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();


        $totalRevenue = Revenue::whereBetween('date', [$startDate, $endDate])->sum('amount');
        
        return response()->json(['revenue' => $totalRevenue]);
    }

    public function getRevenueForBranchOrSchool(Request $request, $schoolId, $branchId = null)
    {
        try {
            $school = School::findOrFail($schoolId);
    
            if ($branchId) {
                $branch = Branch::where('school_id', $schoolId)->findOrFail($branchId);
                $revenue = $branch->revenues->sum('amount');
                $expenses = $branch->expenses->sum('amount');
        
                return response()->json([
                    'branch_name' => $branch->name,
                    'revenue' => $revenue,
                    'expenses' => $expenses
                ]);
            } else {
                $revenue = $school->revenues->sum('amount');
                $expenses = $school->expenses->sum('amount');
                
                return response()->json([
                    'school_name' => $school->name,
                    'revenue' => $revenue,
                    'expenses' => $expenses
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Resource not found.'], 404);
        }
    }

    public function getRevenueByTypeAndMethod(Request $request)
    {
        // Group revenues by type and payment method
        $revenueData = Revenue::select('type', 'payment_method', \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type', 'payment_method')
            ->get();
        
        return response()->json($revenueData);
    }
}