<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

use App\Http\Controllers\AdminUserController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/admin_users', [AdminUserController::class, 'index'])->name('admin.index');
    Route::get('/create', [AdminUserController::class, 'create'])->name('admin.create');
    Route::post('/', [AdminUserController::class, 'store'])->name('admin.store');
    Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.edit');
    Route::put('/{id}', [AdminUserController::class, 'update'])->name('admin.update');
    Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('admin.destroy');
});






Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');