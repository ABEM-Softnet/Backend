<?php

namespace App\Http\Controllers;


use App\Models\Branch;
use App\Models\School;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Log;

class RevenueController extends Controller
{
    public function index()
    {
        // Retrieve all revenue entries
        $revenues = Revenue::all();
        return response()->json($revenues);
    }

    public function store(Request $request)
    {
        // Create a new revenue entry
        $revenue = Revenue::create($request->all());
        return response()->json($revenue, 201);
    }

    public function getTotalRevenue(Request $request)
    {
        // Get total revenue for the current month
        $totalRevenue = Revenue::with('date')->sum('amount');
        
        return response()->json(['total_revenue' => $totalRevenue]);
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
        $school = School::findOrFail($schoolId);

        if ($branchId) {
            // If a branch ID is provided, get revenue for the specific branch
            $branch = Branch::where('school_id', $schoolId)->findOrFail($branchId);
            $revenue = $branch->revenues->sum('amount');
        } else {
            // If no branch ID is provided, get total revenue for the school
            $revenue = $school->revenues->sum('amount');
        }

        return response()->json(['revenue' => $revenue]);
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