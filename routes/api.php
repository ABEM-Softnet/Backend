<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ExpenseController;
use App\Http\Controllers\Api\v1\RevenueController;
use App\Http\Controllers\Api\v1\FinancialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test', function () {
    return response()->json(['message' => 'This is a test route'], 200);
});

Route::prefix('v1')->group(function () {
    Route::get('/revenue/total', [RevenueController::class, 'getTotalRevenue']);
    Route::get('/revenue/today', [RevenueController::class, 'getTodayRevenue']);
    Route::get('/revenue/this-week', [RevenueController::class, 'getThisWeekRevenue']);
    Route::get('/revenue/this-month', [RevenueController::class, 'getThisMonthRevenue']);
    Route::get('/revenue/this-year', [RevenueController::class, 'getThisYearRevenue']);
    Route::get('/revenue/by-monthYear', [RevenueController::class, 'getRevenueByMonthYear']);

    Route::get('/expenses/total', [ExpenseController::class, 'getTotalExpenses']);
    Route::get('/expenses/today', [ExpenseController::class, 'getTodayExpenses']);
    Route::get('/expenses/this-week', [ExpenseController::class, 'getThisWeekExpenses']);
    Route::get('/expenses/this-month', [ExpenseController::class, 'getThisMonthExpenses']);
    Route::get('/expenses/this-year', [ExpenseController::class, 'getThisYearExpenses']);
    Route::get('/expenses/by-monthYear', [ExpenseController::class, 'getExpensesByMonthYear']);
    Route::get('/expenses/by-typeTime', [ExpenseController::class, 'getExpenseByTypeAndTime']);

    //get specific branch revenue and expenses
    Route::get('/financials/{school_id}/branch/{branchId?}', [RevenueController::class, 'getRevenueForBranchOrSchool']);
    
    //shows list of branches, their total expense and revenue
    Route::get('/financials/total', [FinancialController::class, 'getAllBranchFinancials']);
});
