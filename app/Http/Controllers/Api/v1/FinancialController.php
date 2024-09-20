<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Branch;
use App\Models\Expense;
use App\Models\Revenue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FinancialController extends Controller
{
    public function getAllBranchFinancials()
{
    $branchesData = [];

    $branches = Branch::all();

    foreach ($branches as $branch) {
        $revenue = Revenue::where('branch_id', $branch->id)->sum('amount');
        $expenses = Expense::where('branch_id', $branch->id)->sum('amount');

        $branchData = [
            'branch' => $branch->name,
            'total_revenue' => $revenue,
            'total_expense' => $expenses
        ];

        $branchesData[] = $branchData;
    }

    return response()->json($branchesData);
}
}
