<?php

use App\Http\Controllers\Auth\Api\ApiAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('register',[ApiAuthController::class, 'register']);
    Route::post('login',[ApiAuthController::class, 'personalLogin']);
    Route::post('password-login',[ApiAuthController::class, 'passwordGrantLogin']);
    Route::post('forgot-password',[ApiAuthController::class, 'forgotPassword']);
    Route::post('reset-password',[ApiAuthController::class, 'resetPassword']);
});

Route::middleware('auth:user-api')->group(function () {
    Route::get('categories', [CategoryController::class , 'index']);
    Route::get('categories/{category}', [CategoryController::class , 'show']);

    Route::apiResource('tasks' , TaskController::class);
});

Route::prefix('auth')->middleware('auth:user-api')->group(function () {
    Route::post('change-password',[ApiAuthController::class, 'changePassword']);
    Route::get('logout',[ApiAuthController::class, 'logout']);
});
