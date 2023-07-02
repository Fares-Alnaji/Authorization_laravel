<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ParmissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/* --------------- Login ---------------*/
Route::prefix('cms')->middleware('guest:admin')->group(function(){
    Route::get('{guard}/login', [AuthController::class , 'showLogin'])->name('auth.login');
    Route::post('login', [AuthController::class , 'login']);
});


/* --------------- Dashboard ---------------*/
Route::prefix('cms/admin')->middleware(['auth:admin,user' , 'verified'])->group(function(){
    Route::view('/', 'temp')->name('cms.dashboard');
    Route::resource('cities' , CityController::class);
    Route::resource('admins' , AdminController::class);
    Route::get('logout', [AuthController::class , 'logout'])->name('auth.logout');
    Route::get('edit-password', [AuthController::class , 'editPassword'])->name('auth.edit-password');
    Route::put('edit-password', [AuthController::class , 'updatePassword']);
});

/* ---------------- Roles & Permission ---------------*/
Route::prefix('cms/admin')->middleware(['auth:admin' ,'verified'])->group(function(){
    Route::resource('roles' , RoleController::class);
    Route::resource('permissions' , ParmissionController::class);

    Route::resource('users' , UserController::class);

    Route::get('roles/{role}/permissions', [RoleController::class , 'editRolePermissions'])->name('role.edit-permissions');
    Route::put('roles/{role}/permissions', [RoleController::class , 'updateRolePermissions']);

    Route::get('users/{user}/permissions', [UserController::class , 'editPermissions'])->name('user.edit-permissions');
    Route::put('users/{user}/permissions', [UserController::class , 'updatePermissions']);

});

    Route::prefix('email')->middleware('auth:admin,user')->group(function(){
    Route::get('verify' , [EmailVerificationController::class , 'notice'])->name('verification.notice');
    Route::get('verification-notification' , [EmailVerificationController::class , 'send'])->name('verification.send');
    Route::get('verify/{id}/{hash}' , [EmailVerificationController::class , 'verify'])->name('verification.verify');
});
