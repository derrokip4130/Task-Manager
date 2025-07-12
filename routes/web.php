<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/user_dashboard', [UserDashboardController::class, 'dashboard'])->middleware('auth');

Route::get('/admin_dashboard', function () {
    return view('admin_dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin_dashboard', [AdminUserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::post('tasks/', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/update-task-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

Route::get('/register', [AuthController::class, 'showAdminRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerAdmin']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
Route::post('/change-password', [AuthController::class, 'ChangePassword']);
