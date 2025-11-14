<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\WaliKelas\DashboardController as WaliKelasDashboard;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




// Route untuk Admin
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    // ... route lain untuk admin (manage sekolah, tahun ajaran)
});

// Route untuk Petugas
Route::middleware(['auth', 'role.petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
    Route::post('/scan/process', [AttendanceController::class, 'processScan'])->name('scan.process');
    // ... route lain untuk petugas (rekap absen, generate QR)
    
    Route::get('/students/{id}/qrcode', [StudentController::class, 'generateQrCode'])->name('students.qrcode');
});

// Route untuk Wali Kelas
Route::middleware(['auth', 'role.wali_kelas'])->prefix('wali_kelas')->name('wali_kelas.')->group(function () {
    Route::get('/dashboard', [WaliKelasDashboard::class, 'index'])->name('dashboard');
    // ... route untuk melihat rekap siswa di kelasnya
});

// Route default dashboard setelah login
Route::get('/dashboard', function () {
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'petugas') {
        return redirect()->route('petugas.dashboard');
    } elseif (Auth::user()->role == 'wali_kelas') {
        return redirect()->route('wali_kelas.dashboard');
    }
})->middleware(['auth']);