<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    public function getTotalExpenses(Request $request)
    {
        $currentYear = date('Y');
    
        // Retrieve expenses with type, amount, branch name, and date, filtered by the current year and ordered by date
        $expenses = Expense::with('branch')
                            ->select('type', 'amount', 'date', 'branch_id')
                            ->whereYear('date', $currentYear)
                            ->orderBy('date')
                            ->get();
    
        $expensesByType = [];
    
        foreach ($expenses as $expense) {
            $expenseType = $expense->type;
            $amount = (float) $expense->amount;
            $month = date('F', strtotime($expense->date)); // Extract month as a full month name
    
            // Safely get the branch name using optional() to prevent errors if branch is null
            $branchName = optional($expense->branch)->name;
    
            // Group expenses by type with month and include the branch name
            if (!isset($expensesByType[$expenseType])) {
                $expensesByType[$expenseType] = [];
            }
    
            $expensesByType[$expenseType][] = [
                'month' => $month,
                'amount' => $amount,
                'branch' => $branchName
            ];
        }
    
        return response()->json(['expenses' => $expensesByType]);
    }
    public function getTodayExpenses(Request $request)
    {
        // Get total expenses of today
        $totalExpense = Expense::whereDay('date', now()->day)->sum('amount');
        
        return response()->json(['today_expense' => $totalExpense]);
    }
    public function getThisWeekExpenses(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        // Get total expenses for the current week
        $totalExpense = Expense::whereBetween('date', [$startOfWeek, $endOfWeek])->sum('amount');

        return response()->json(['this_week_expense' => $totalExpense]);
    }
    public function getThisMonthExpenses(Request $request)
    {
        // Get total expenses for the current month
        $totalExpense = Expense::whereMonth('date', now()->month)->sum('amount');
        
        return response()->json(['this_month_expense' => $totalExpense]);
    }
    public function getThisYearExpenses(Request $request)
    {
        // Get total expenses for the this year
        $totalExpense = Expense::whereYear('date', now()->year)->sum('amount');
        
        return response()->json(['this_year_expense' => $totalExpense]);
    }

    
    public function getExpensesByMonthYear(Request $request)
    {
        // Get total expenses for the input month and year
        $month = $request->input('month');
        $year = $request->input('year');

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();


        $totalExpense = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');
        
        return response()->json(['this_monthYear_total_expense' => $totalExpense]);
    }

    public function getExpenseByTypeAndTime(Request $request)
    {
        // Group expenses by type and time
        $expenseData = Expense::select('type', \DB::raw('YEAR(date) as year'), \DB::raw('MONTH(date) as month'), \DB::raw('SUM(amount) as total_amount'))
            ->groupBy('type', 'year', 'month')
            ->get();
        
        return response()->json($expenseData);
    }
}