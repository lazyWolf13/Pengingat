<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FormPengingatController;
use App\Http\Controllers\Admin\RekapPengingatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PhotoController;

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
use App\Http\Controllers\Admin\AttendanceRecordsController;

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

    Route::resource('attendance', AttendanceRecordsController::class);
   
    // Attendance Routes
    Route::controller(App\Http\Controllers\Admin\AttendanceRecordsController::class)->group(function () {
        // Main Attendance Routes
        Route::get('/attendance', 'index')->name('attendance.index');
        Route::get('/attendance/create', 'create')->name('attendancecreate.create');
        Route::post('/attendance', 'store')->name('attendance.store');
        Route::get('/attendance/{record}', 'show')->name('attendance.show');
        Route::get('/attendance/{record}/edit', 'edit')->name('attendanceedit.edit');
        Route::put('/attendance/{record}', 'update')->name('attendance.update');
        Route::delete('/attendance/{record}', 'destroy')->name('attendance.destroy');
        
        // Export Routes
        Route::get('/attendance/export/excel', 'exportExcel')->name('attendance.export.excel');
        Route::get('/attendance/export/pdf', 'exportPdf')->name('attendance.export.pdf');
    });

    // Kategori Routes
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // Post Routes
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostsController::class, 'index'])->name('index');
        Route::get('/create', [PostsController::class, 'create'])->name('create');
        Route::post('/', [PostsController::class, 'store'])->name('store');
        Route::get('/{post}', [PostsController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostsController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostsController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostsController::class, 'destroy'])->name('destroy');
        Route::post('/{post}/publish', [PostsController::class, 'publish'])->name('publish');
        Route::post('/{post}/unpublish', [PostsController::class, 'unpublish'])->name('unpublish');
    });

    // Gallery Routes
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/create', [GalleryController::class, 'create'])->name('create');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
        Route::post('/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('image')->name('image.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ImageController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\ImageController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\ImageController::class, 'store'])->name('store');
        Route::get('/{image}/edit', [App\Http\Controllers\Admin\ImageController::class, 'edit'])->name('edit');
        Route::put('/{image}', [App\Http\Controllers\Admin\ImageController::class, 'update'])->name('update');
        Route::delete('/{image}', [App\Http\Controllers\Admin\ImageController::class, 'destroy'])->name('destroy');
        Route::post('/{image}/toggle-status', [App\Http\Controllers\Admin\ImageController::class, 'toggleStatus'])->name('toggle-status');
    });    
});

use App\Http\Controllers\UserDashboardController;

Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

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
    Route::get('/user/pengingat/{id}', [FormPengingatController::class, 'show'])->name('user.pengingat.show');
    Route::get('/user/pengingat/{id}/download', [FormPengingatController::class, 'download'])->name('user.pengingat.download');
    Route::get('/user/pengingat/{id}/view', [FormPengingatController::class, 'viewFile'])->name('user.pengingat.view');
    Route::post('/user/pengingat/{id}/selesai', [FormPengingatController::class, 'selesai'])->name('user.pengingat.selesai');
});

Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // Form Pengingat Routes
    Route::get('/form-pengingat', [FormPengingatController::class, 'create'])->name('user.form_pengingat.create');
    Route::post('/form-pengingat', [FormPengingatController::class, 'store'])->name('user.form_pengingat.store');

    // Progress Routes
    Route::get('/user/progress', [FormPengingatController::class, 'progress'])->name('user.progress');
    Route::post('/user/progress', [FormPengingatController::class, 'selesai'])->name('user.progress.post');
});

//rekap pengingat tugas
Route::get('admin/rekap-pengingat', [RekapPengingatController::class, 'index'])->name('admin.rekap_pengingat');
Route::get('admin/rekap-pengingat/{id}', [RekapPengingatController::class, 'show'])->name('admin.rekap_pengingat.show');
//TAMPILAN FRONTEND
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);