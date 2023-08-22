<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;

Auth::routes();

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/send_email', [DashboardController::class, 'sendEmail'])->name('dashboard.send_email');
Route::get('/users', [userController::class, 'index'])->name('index');
Route::get('/users/get_users_data', [UserController::class, 'get_users_data'])->name('get_users_data');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('permissions', PermissionController::class);
    Route::get('/get_permissions_data', [PermissionController::class, 'get_permissions_data'])->name('get_permissions_data');
    Route::resource('roles', RoleController::class);
    Route::get('/get_roles_data', [roleController::class, 'get_roles_data'])->name('get_roles_data');
    Route::resource('users', UserController::class);
    Route::get('/get_users_data', [UserController::class, 'get_users_data'])->name('get_users_data');
    Route::get('/tenants', [UserController::class, 'tenants'])->name('tenants');
    Route::get('/get_tenants_data', [UserController::class, 'get_tenants_data'])->name('get_tenants_data');
    Route::get('/agents', [UserController::class, 'agents'])->name('agents');
    Route::get('/get_agents_data', [UserController::class, 'get_agents_data'])->name('get_agents_data');
    Route::resource('bookings', BookingController::class);
    Route::get('/get_bookings_data', [BookingController::class, 'get_bookings_data'])->name('get_bookings_data');
    Route::resource('transactions', TransactionController::class);
    Route::get('/get_transactions_data', [TransactionController::class, 'get_transactions_data'])->name('get_transactions_data');
});