<?php

use App\Http\Controllers\Api\v1\EmailVerificationController;
use App\Http\Controllers\Api\v1\NewPasswordController;
use App\Http\Controllers\Api\v1\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function(){

});


