<?php

use Illuminate\Support\Facades\Route;

// Screen 1: Login
Route::get('/', function () {
    return view('login');
})->name('login');

// Screen 2: Dashboard Mahasiswa
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Screen 3: Detail Tugas
Route::get('/tugas/{id}', function ($id) {
    return view('detail-tugas', ['id' => $id]);
})->name('detail-tugas');

// Screen 4: Per Mata Kuliah
Route::get('/per-mk', function () {
    return view('per-mk');
})->name('per-mk');

// Screen 5: Weekly Overview
Route::get('/weekly', function () {
    return view('weekly');
})->name('weekly');

// Screen 6: Kalender
Route::get('/kalender', function () {
    return view('kalender');
})->name('kalender');

// Screen 7: Tambah Event
Route::get('/tambah-event', function () {
    return view('tambah-event');
})->name('tambah-event');

// Screen 8: Alert Bentrok (akan muncul sebagai modal)

// Screen 9: Dashboard Dosen
Route::get('/dashboard-dosen', function () {
    return view('dashboard-dosen');
})->name('dashboard-dosen');

// Screen 10: Setup Reminder
Route::get('/setup-reminder', function () {
    return view('setup-reminder');
})->name('setup-reminder');

// Screen 11: Laporan
Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

// Screen 12: Dashboard Skripsi
Route::get('/dashboard-skripsi', function () {
    return view('dashboard-skripsi');
})->name('dashboard-skripsi');

// Screen 13: Timeline
Route::get('/timeline', function () {
    return view('timeline');
})->name('timeline');

// Screen 14: Focus Mode
Route::get('/focus-mode', function () {
    return view('focus-mode');
})->name('focus-mode');

// Screen 15: Upload Progress
Route::get('/upload-progress', function () {
    return view('upload-progress');
})->name('upload-progress');