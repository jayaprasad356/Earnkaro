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
use App\Http\Controllers\NewsController;
use App\Http\Controllers\InactiveUsersController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\ProductsController;


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
Route::get('/level4List', [UsersController::class, 'level4List'])->name('level_4.index');
Route::get('/news', [NewsController::class, 'invite_friends'])->name('invite_friends.index');
Route::get('/inactive-users', [InactiveUsersController::class, 'index'])->name('inactive_users.index');
Route::post('/inactive-users/activate/{id}', [InactiveUsersController::class, 'activate'])->name('inactive_users.activate');
Route::get('/inactive-users/activate', [InactiveUsersController::class, 'activate'])->name('inactive_users.activate');
Route::get('/inactive-users/activate-level', [InactiveUsersController::class, 'showActivationPage'])->name('inactive_users.showActivationPage');
Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
Route::get('/works', [WorksController::class, 'index'])->name('works.index');
Route::get('/withdrawals', [WithdrawalsController::class, 'index'])->name('withdrawals.index');
Route::resource('withdrawals', WithdrawalsController::class);
Route::resource('my_products', ProductsController::class);
Route::get('/bankdetails/update', [BankDetailsController::class, 'showUpdateForm'])->name('bankdetails.update');
Route::post('/bankdetails/update', [BankDetailsController::class, 'update'])->name('bankdetails.update');
Route::post('/bankdetails/update', [BankDetailsController::class, 'update'])->name('bankdetails.update');
Route::get('/withdrawals/show', [WithdrawalsController::class, 'show'])->name('withdrawals.show');
Route::resource('withdrawals', WithdrawalsController::class)->except(['show']);
Route::post('/withdrawals/submit', [WithdrawalsController::class, 'submitWithdrawal'])->name('withdrawals.submit');
Route::get('/inactive-users/get-level-users', [InactiveUsersController::class, 'getLevelUsers'])->name('inactive_users.getLevelUsers');
Route::get('/inactive-users/addusers', [InactiveUsersController::class, 'addusers'])->name('inactive_users.addusers');
Route::post('/inactive-users/register', [InactiveUsersController::class, 'register'])->name('inactive_users.register');
Route::get('/inactive-users/activateusers', [InactiveUsersController::class, 'activateusers'])->name('inactive_users.activateusers');
Route::get('/news/download/{id}', [NewsController::class, 'downloadImage'])->name('news.download');

// Handle Image Upload (POST)
Route::post('/works/upload', [WorksController::class, 'uploadImage'])->name('works.upload');
Route::post('/balance/add', [HomeController::class, 'addToBalance'])->name('balance.add');