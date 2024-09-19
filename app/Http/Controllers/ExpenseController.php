<?php

namespace App\Http\Controllers;


use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        // Retrieve all expense entries
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    public function store(Request $request)
    {
        // Create a new expense entry
        $expense = Expense::create($request->all());
        return response()->json($expense, 201);
    }

    public function getTotalExpenses(Request $request)
    {
        // Get total expenses for the current week
        $totalExpense = Expense::with('date')->sum('amount');
        
        return response()->json(['total_expense' => $totalExpense]);
    }
    public function getTodayExpenses(Request $request)
    {
        // Get total expenses for the current week
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
        // Get total expenses for the current week
        $totalExpense = Expense::whereWeek('date', now()->month)->sum('amount');
        
        return response()->json(['this_week_expense' => $totalExpense]);
    }
    public function getThisYearExpenses(Request $request)
    {
        // Get total expenses for the current week
        $totalExpense = Expense::whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
        
        return response()->json(['this_week_expense' => $totalExpense]);
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