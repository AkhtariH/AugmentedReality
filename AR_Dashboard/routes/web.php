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
use App\Http\Controllers\Auth\LoginController;

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
    Route::resource('/home', App\Http\Controllers\ArtObjectController::class)->names('home');

    // Profile
    Route::resource('/profile', ProfileController::class)
        ->names('profile');

    Route::get('/logout', [LoginController::class, 'logout']);
    
});

Route::middleware(['auth', 'is_admin'])->group( function () {
    // Admin Panel
    Route::resource('/admin', AdminController::class)
        ->names('admin');
    Route::get('/admin/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::get('/admin/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
    Route::get('/admin/{id}/simulator', [AdminController::class, 'simulator'])->name('admin.simulator');
});

Auth::routes();