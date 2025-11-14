<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\WaliKelas\DashboardController as WaliKelasDashboard;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman utama (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Route untuk autentikasi (login, register, logout, dll.)
require __DIR__.'/auth.php';

// Route default dashboard setelah login
Route::get('/dashboard', function () {
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'petugas') {
        return redirect()->route('petugas.dashboard');
    } elseif (Auth::user()->role == 'wali_kelas') {
        return redirect()->route('wali_kelas.dashboard');
    }
})->middleware(['auth'])->name('dashboard');


// Route untuk Admin
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    // ... route lain untuk admin (manage sekolah, tahun ajaran)
    Route::resource('schools', SchoolController::class);
    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('users', UserController::class);
});

// Route untuk Petugas
Route::middleware(['auth', 'role.petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/qrcode', [StudentController::class, 'generateQrCode'])->name('students.qrcode');
    Route::resource('classrooms', ClassroomController::class);
    Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
    Route::post('/scan/process', [AttendanceController::class, 'processScan'])->name('scan.process');
    
    // ... route lain untuk petugas (rekap absen, generate QR)
});

// Route untuk Wali Kelas
Route::middleware(['auth', 'role.wali_kelas'])->prefix('wali_kelas')->name('wali_kelas.')->group(function () {
    Route::get('/dashboard', [WaliKelasDashboard::class, 'index'])->name('dashboard');
    Route::get('/students/{student}/attendance-graph', [WaliKelasDashboard::class, 'showAttendanceGraph'])->name('students.attendance.graph');
    // ... route untuk melihat rekap siswa di kelasnya
});