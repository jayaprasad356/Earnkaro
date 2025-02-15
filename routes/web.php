<?php

use App\Http\Controllers\AamarpayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\WithdrawalsController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppsettingsController;
use App\Http\Controllers\CoinsController;
use App\Http\Controllers\UserCallsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\WorksController;

// use App\Http\Controllers\PlanRequestController;

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

// Redirect root to login if not authenticated
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('mobile.login');
});

// Authentication routes
Route::get('mobile-login', [CustomLoginController::class, 'showLoginForm'])->name('mobile.login');
Route::post('mobile-login', [CustomLoginController::class, 'login']);
Route::post('logout', [CustomLoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

// Resources
Route::get('/level1List', [UsersController::class, 'level1List'])->name('level_1.index');
Route::get('/level2List', [UsersController::class, 'level2List'])->name('level_2.index');
Route::get('/level3List', [UsersController::class, 'level3List'])->name('level_3.index');
// Show Works List Page with Upload Form
Route::get('/works', [WorksController::class, 'index'])->name('works.index');

// Handle Image Upload (POST)
Route::post('/works/upload', [WorksController::class, 'uploadImage'])->name('works.upload');
