<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThresholdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BridgeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\TTNController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\DateFilterController;
use App\Http\Controllers\HpdController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});

// Forgot password
Route::middleware('guest')->group( function () {
    Route::get('forgot-password', [PasswordResetController::class, 'index'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'email'])
        ->name('password.email');
    Route::get('reset-password/{token}/{email?}', [PasswordResetController::class, 'reset'])
        ->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'update'])
        ->name('password.update');
});



Route::middleware('auth')->group( function () {
    // Dashboard
    Route::resource('dashboard', DashboardController::class)
        ->names('dashboard');

    // Profile
    Route::resource('/profile', ProfileController::class)
        ->names('profile');
});

Route::middleware(['auth', 'is_admin'])->group( function () {
    // Admin Panel
    Route::resource('admin/user', UserController::class)
        ->names('admin.user');
    Route::get('admin', [AdminController::class, 'index'])
        ->name('admin.index');
    Route::post('admin/assign', [AdminController::class, 'assign'])
        ->name('admin.assign');
    Route::post('admin/user/overtime', [AdminController::class, 'overtime_email'])
        ->name('admin.user.overtime');
    Route::post('admin/user/overtime/max', [AdminController::class, 'overtime_max'])
        ->name('admin.user.overtimemax');
    Route::post('admin/delete', [AdminController::class, 'deleteAssign'])
        ->name('admin.delete');


    Route::resource('/admin/hours-per-day', HpdController::class)
        ->names('admin.hpd');
    Route::resource('/admin/holiday', HolidayController::class)
        ->names('admin.holiday');    

});



// AJAX requests
Route::post('hpd', [DashboardController::class, 'getHPD'])
    ->middleware('auth')
    ->name('hpd');
Route::post('fire', [TTNController::class, 'index']);

Auth::routes();

Route::resource('/home', App\Http\Controllers\ArtObjectController::class)->names('home');