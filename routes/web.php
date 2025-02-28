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

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/adminuser', [AdminUserController::class, 'index'])->name('adminusers.index');
    Route::get('/adminuser/create', [AdminUserController::class, 'create'])->name('adminusers.create');
    Route::post('/adminuser', [AdminUserController::class, 'store'])->name('adminusers.store');
    Route::get('/adminuser/{adminuser}/edit', [AdminUserController::class, 'edit'])->name('adminusers.edit');
    Route::put('/adminuser/{adminuser}', [AdminUserController::class, 'update'])->name('adminusers.update');
    Route::delete('/adminuser/{adminuser}', [AdminUserController::class, 'destroy'])->name('adminusers.destroy');
    Route::resource('users', UserController::class);
    Route::get('/user', function () {
        $users = \App\Models\User::all();
        return view('admin.user', compact('users'));
    })->name('users.index');
    
    Route::get('/user/create', function () {
        return view('admin.usercreate');
    })->name('users.create');

    Route::resource('adminuser', AdminUserController::class, ['names' => 'adminusers']);
});

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');