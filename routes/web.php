<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\SkripsiController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// General Auth Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dosen-specific Auth Routes
Route::prefix('dosen')->group(function () {
    Route::get('/login', [AuthController::class, 'showDosenLogin'])->name('dosen.login');
    Route::post('/login', [AuthController::class, 'dosenLogin'])->name('dosen.login.post');
    Route::get('/register', [AuthController::class, 'showDosenRegister'])->name('dosen.register');
    Route::post('/register', [AuthController::class, 'dosenRegister'])->name('dosen.register.post');
});

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('mahasiswa')->group(function () {
    // Screen 2: Dashboard (HMW 1 - Emphasis)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('mahasiswa.dashboard');

    // Screen 3: Detail Tugas - Custom routes untuk detail, complete, update
    Route::get('/tugas/{id}', [TaskController::class, 'show'])->name('mahasiswa.tugas.detail');
    Route::post('/tugas/{id}/complete', [TaskController::class, 'complete'])->name('mahasiswa.tugas.complete');
    Route::put('/tugas/{id}', [TaskController::class, 'update'])->name('mahasiswa.tugas.update');

    // Screen 4: Per Mata Kuliah (HMW 4 - Proximity)
    Route::get('/per-mk', [TaskController::class, 'perMataKuliah'])->name('mahasiswa.per-mk');

    // Screen 5: Weekly Overview
    Route::get('/weekly', [TaskController::class, 'weekly'])->name('mahasiswa.weekly');

    // Screen 6: Kalender (HMW 3 - Balance)
    Route::get('/kalender', [CalendarController::class, 'index'])->name('mahasiswa.kalender');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('mahasiswa.calendar');
    Route::post('/event', [CalendarController::class, 'storeEvent'])->name('mahasiswa.event.store');
    Route::post('/activity', [ActivityController::class, 'store'])->name('mahasiswa.activity.store');
    Route::post('/activity/force', [ActivityController::class, 'store'])->name('mahasiswa.activity.store.force');
    Route::get('/tambah-event', [CalendarController::class, 'create'])->name('mahasiswa.tambah-event');
    Route::post('/tambah-event', [CalendarController::class, 'store'])->name('mahasiswa.tambah-event.store');

    // Screen 12-15: Skripsi (HMW 5 - White Space)
    Route::get('/skripsi', [SkripsiController::class, 'index'])->name('mahasiswa.skripsi');
    Route::get('/skripsi/upload', [SkripsiController::class, 'showUploadForm'])->name('mahasiswa.upload-bab');
    Route::post('/skripsi/upload', [SkripsiController::class, 'uploadChapter'])->name('mahasiswa.upload-chapter');
    Route::get('/skripsi/feedback', [SkripsiController::class, 'showFeedback'])->name('mahasiswa.feedback');
    Route::get('/skripsi/schedule', [SkripsiController::class, 'showSchedule'])->name('mahasiswa.schedule');
    Route::post('/skripsi/feedback/{feedbackId}/resolve', [SkripsiController::class, 'resolveFeedback'])->name('mahasiswa.feedback.resolve');
    Route::get('/skripsi/chapter/{submissionId}/download', [SkripsiController::class, 'downloadChapter'])->name('mahasiswa.chapter.download');

    Route::get('/timeline', [SkripsiController::class, 'timeline'])->name('mahasiswa.timeline');
    Route::get('/focus-mode', [DashboardController::class, 'focusMode'])->name('mahasiswa.focus-mode');
    Route::get('/upload-progress', [DashboardController::class, 'uploadProgress'])->name('mahasiswa.upload-progress');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('mahasiswa.profile');

    // CRUD Tugas - Store dan Delete
    Route::post('/tugas', [TaskController::class, 'store'])->name('mahasiswa.tugas.store');
    Route::delete('/tugas/{id}', [TaskController::class, 'destroy'])->name('mahasiswa.tugas.destroy');
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

    // Profile
    Route::get('/profile', [DosenController::class, 'profile'])->name('dosen.profile');
});
