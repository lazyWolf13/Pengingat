<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FormPengingatController;
use App\Http\Controllers\Admin\RekapPengingatController;

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
use App\Http\Controllers\Admin\FotoController;
use App\Http\Controllers\Admin\LeaveRequestController;

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
    Route::resource('foto', FotoController::class);
    
    // Foto Routes
    Route::get('/foto', [FotoController::class, 'index'])->name('foto.index');
    Route::get('/foto/create', [FotoController::class, 'create'])->name('fotocreate.create');
    Route::post('/foto', [FotoController::class, 'store'])->name('fotocreate.store');
    Route::get('/foto/{foto}', [FotoController::class, 'show'])->name('foto.show');
    Route::get('/foto/{foto}/edit', [FotoController::class, 'edit'])->name('fotoedit.edit');
    Route::put('/foto/{foto}', [FotoController::class, 'update'])->name('foto.update');
    Route::delete('/foto/{foto}', [FotoController::class, 'destroy'])->name('foto.destroy');

    
    // Leave Request Routes
    Route::get('/leavereq', [LeaveRequestController::class, 'index'])->name('leavereq.index');
    Route::get('/leavereq/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leavereq.show');
    Route::post('/leavereq/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leavereq.approve');
    Route::delete('/leavereq/{leaveRequest}', [LeaveRequestController::class, 'destroy'])->name('leavereq.destroy');
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

//route pengingat_tugas
// Route untuk form pengingat (create dan store)
Route::get('/form_pengingat', [FormPengingatController::class, 'create'])->name('user.form_pengingat.create');
Route::post('/form_pengingat', [FormPengingatController::class, 'store'])->name('user.form_pengingat.store');

// Route untuk pengingat dashboard (setelah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/pengingat', [FormPengingatController::class, 'dashboard'])->name('user.pengingat');
    
    // Menambahkan route untuk menampilkan pengingat
    Route::get('/user/pengingat/index', [FormPengingatController::class, 'index'])->name('user.pengingat.index');
});

Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // Form Pengingat Routes
    Route::get('/form-pengingat', [FormPengingatController::class, 'create'])->name('user.form_pengingat.create');
    Route::post('/form-pengingat', [FormPengingatController::class, 'store'])->name('user.form_pengingat.store');
});

//rekap pengingat tugas
Route::get('admin/rekap-pengingat', [RekapPengingatController::class, 'index'])->name('admin.rekap_pengingat');
Route::get('admin/rekap-pengingat/{id}', [RekapPengingatController::class, 'show'])->name('admin.rekap_pengingat.show');