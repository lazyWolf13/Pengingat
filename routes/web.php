<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AttendanceSummaryController;
use App\Http\Controllers\Admin\ProfileController;

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
    Route::resource('summaries', AttendanceSummaryController::class);

    // Route untuk Attendance Summary
    Route::get('/summaries', [AttendanceSummaryController::class, 'index'])->name('summaries.index');
    Route::get('/summaries/generate', [AttendanceSummaryController::class, 'showGenerate'])->name('summaries.showGenerate');
    Route::post('/summaries/generate', [AttendanceSummaryController::class, 'generate'])->name('summariesgenerate');
    Route::get('summaries/create', [AttendanceSummaryController::class, 'create'])->name('summariescreate.create');
    Route::post('summaries', [AttendanceSummaryController::class, 'store'])->name('summaries.store');
    Route::get('summaries/{attendanceSummary}/edit', [AttendanceSummaryController::class, 'edit'])->name('summaries.edit');
    Route::put('summaries/{attendanceSummary}', [AttendanceSummaryController::class, 'update'])->name('summaries.update');
    Route::delete('summaries/{attendanceSummary}', [AttendanceSummaryController::class, 'destroy'])->name('summaries.destroy');
    Route::resource('profiles', ProfileController::class);

    // Menampilkan daftar profil
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('profiles/create', [ProfileController::class, 'create'])->name('profilescreate.create');
    Route::post('profiles', [ProfileController::class, 'store'])->name('profilescreate.store');
    Route::get('profiles/{profile}/edit', [ProfileController::class, 'edit'])->name('profilesedit.edit');
    Route::put('profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::get('/users/count-by-department/{department}', [AttendanceSummaryController::class, 'countByDepartment']);
});

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

use App\Http\Controllers\AttendanceRecordController;

Route::middleware(['auth'])->group(function () {
    Route::get('/user/attendance', [AttendanceRecordController::class, 'index'])->name('user.attendance');
    Route::post('/user/absen-masuk', [AttendanceRecordController::class, 'absenMasuk'])->name('user.absen.masuk');
    Route::post('/user/absen-pulang', [AttendanceRecordController::class, 'absenPulang'])->name('user.absen.pulang');
});

use App\Http\Controllers\AttendanceHistoryController;

Route::middleware(['auth'])->group(function () {
    Route::get('user/attendance-history', [AttendanceHistoryController::class, 'index'])->name('user.attendance_history');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
