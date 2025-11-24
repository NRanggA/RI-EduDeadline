<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DosenController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    // Screen 2: Dashboard (HMW 1 - Emphasis)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mahasiswa.dashboard');
    
    // Screen 3: Detail Tugas
    Route::get('/tugas/{id}', [TaskController::class, 'show'])->name('mahasiswa.tugas.detail');
    
    // Screen 4: Per Mata Kuliah (HMW 4 - Proximity)
    Route::get('/per-mk', [TaskController::class, 'perMataKuliah'])->name('mahasiswa.per-mk');
    
    // Screen 5: Weekly Overview
    Route::get('/weekly', [TaskController::class, 'weekly'])->name('mahasiswa.weekly');
    
    // Screen 6: Kalender (HMW 3 - Balance)
    Route::get('/kalender', [CalendarController::class, 'index'])->name('mahasiswa.kalender');
    
    // Screen 7: Tambah Event
    Route::get('/tambah-event', [CalendarController::class, 'create'])->name('mahasiswa.tambah-event');
    Route::post('/tambah-event', [CalendarController::class, 'store'])->name('mahasiswa.tambah-event.store');
    
    // Screen 12-15: Skripsi (HMW 5 - White Space)
    Route::get('/skripsi', [DashboardController::class, 'skripsi'])->name('mahasiswa.skripsi');
    Route::get('/timeline', [DashboardController::class, 'timeline'])->name('mahasiswa.timeline');
    Route::get('/focus-mode', [DashboardController::class, 'focusMode'])->name('mahasiswa.focus-mode');
    Route::get('/upload-progress', [DashboardController::class, 'uploadProgress'])->name('mahasiswa.upload-progress');
    
    // CRUD Tugas
    Route::resource('tugas', TaskController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('dosen')->group(function () {
    // Screen 9: Dashboard Dosen (HMW 2 - Contrast)
    Route::get('/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
    
    // Screen 10: Setup Reminder
    Route::get('/reminder', [DosenController::class, 'reminder'])->name('dosen.reminder');
    Route::post('/reminder', [DosenController::class, 'sendReminder'])->name('dosen.reminder.send');
    
    // Screen 11: Laporan
    Route::get('/laporan', [DosenController::class, 'laporan'])->name('dosen.laporan');
});