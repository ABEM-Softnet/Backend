<?php

use App\Models\Student;
use App\Http\Controllers\Api\v1\EmailVerificationController;
use App\Http\Controllers\Api\v1\NewPasswordController;
use App\Http\Controllers\Api\v1\SchoolController;
use App\Http\Controllers\Api\v1\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ExpenseController;
use App\Http\Controllers\Api\v1\RevenueController;
use App\Http\Controllers\Api\v1\FinancialController;
use App\Http\Controllers\Api\v1\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/admin-register', [SessionController::class, 'adminRegister']);

Route::post('/login', [SessionController::class, 'login']);

Route::post('/teacher-register',[SessionController::class,'teacherRegister']);

Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);

Route::post('reset-password', [NewPasswordController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function(){
    Route::delete('/user-delete', [SessionController::class, 'destroy']);
    Route::patch('/user-update', [SessionController::class, 'update']);
    Route::post('/logout', [SessionController::class,'logout']);
    Route::get('/verified-middleware', function(){
        return response()->json([
            'message'=> 'The email account is already confirmed now you are able to see this message...',
        ], 201);
    });

    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::post('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    

});


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function(){
    Route::resource('schools', SchoolController::class);
});

// students related routes

Route::prefix('v1')->group(function () {
    Route::get('students', [StudentController::class, 'index']);
    Route::post('students', [StudentController::class, 'store']);
    Route::get('students/{id}', [StudentController::class, 'show']);
    Route::put('students/{id}', [StudentController::class, 'update']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::get('students/{id}/summary', [StudentController::class, 'getStudentSummary']);
});
    

