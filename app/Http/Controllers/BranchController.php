<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        // Retrieve all branches
        $branches = Branch::all();
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        // Create a new branch
        $branch = Branch::create($request->all());
        return response()->json($branch, 201);
    }

    public function getBranchFinancials(Request $request, $branchId)
    {
        // Retrieve revenue and expense data for a specific branch
        $branch = Branch::findOrFail($branchId);
        $revenues = $branch->revenues;
        $expenses = $branch->expenses;
        
        return response()->json(['revenues' => $revenues, 'expenses' => $expenses]);
    }
}
