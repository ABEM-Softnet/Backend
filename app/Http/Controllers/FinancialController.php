<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Expense;
use App\Models\Revenue;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function getBranchFinancials($branch_id)
    {
        $branch = Branch::findOrFail($branch_id);

        $revenue = $branch->revenues()->sum('amount');
        $expenses = $branch->expenses()->sum('amount');

        return response()->json([
            'branch_id' => $branch->id,
            'branch_name' => $branch->name,
            'revenue' => $revenue,
            'expenses' => $expenses
        ]);
    }

    public function getTotalFinancials()
    {
        $totalRevenue = Revenue::sum('amount');
        $totalExpenses = Expense::sum('amount');

        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses
        ]);
    }
}
