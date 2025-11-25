@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">
            👋 Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-white/80">Hari ini kamu punya <strong>{{ $urgentCount ?? 3 }}</strong> tugas mendesak</p>
    </div>
    
    <!-- Filter Bar -->
    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 mb-6 flex flex-wrap gap-3">
        <select class="px-4 py-2 rounded-lg border-0 bg-white text-gray-700 font-medium cursor-pointer">
            <option>Semua Tugas</option>
            <option>Urgent</option>
            <option>Normal</option>
            <option>Rendah</option>
        </select>
        <select class="px-4 py-2 rounded-lg border-0 bg-white text-gray-700 font-medium cursor-pointer">
            <option>Minggu Ini</option>
            <option>Bulan Ini</option>
            <option>Semua</option>
        </select>
        <button class="ml-auto px-6 py-2 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
            + Tambah Tugas
        </button>
    </div>
    
    <!-- Tasks Grid -->
    <div class="grid grid-cols-1 gap-5">
        
        <!-- HMW 1 - EMPHASIS: URGENT TASK -->
        <a href="{{ route('mahasiswa.tugas.detail', ['id' => 1]) }}" class="card-modern card-urgent p-6 block">
            <div class="flex items-start justify-between mb-4">
                <span class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">
                    <span>🔴</span>
                    <span>URGENT!</span>
                </span>
                <span class="text-gray-500 text-sm">3 hari lagi</span>
            </div>
            
            <h3 class="text-2xl font-bold text-red-600 mb-3">
                UAS Pemrograman Web
            </h3>
            
            <div class="space-y-2 text-gray-700">
                <div class="flex items-center gap-2">
                    <span>⏰</span>
                    <span class="font-semibold">22 Oktober 2025, 23:59</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>👤</span>
                    <span>Pak Budi Santoso, M.Kom</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>📚</span>
                    <span>Pemrograman Web B</span>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-600">Final Project Laravel</span>
                <span class="text-purple-600 font-semibold">Lihat Detail →</span>
            </div>
        </a>
        
        <!-- NORMAL TASK 1 -->
        <a href="{{ route('mahasiswa.tugas.detail', ['id' => 2]) }}" class="card-modern p-5 block hover:shadow-xl transition">
            <div class="flex items-start justify-between mb-3">
                <span class="inline-flex items-center gap-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                    Normal
                </span>
                <span class="text-gray-500 text-sm">6 hari lagi</span>
            </div>
            
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                Lab Basis Data - Praktikum 5
            </h3>
            
            <div class="space-y-1 text-gray-600 text-sm">
                <div class="flex items-center gap-2">
                    <span>⏰</span>
                    <span>28 Oktober 2025, 17:00</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>📚</span>
                    <span>Basis Data A</span>
                </div>
            </div>
        </a>
        
        <!-- NORMAL TASK 2 -->
        <a href="{{ route('mahasiswa.tugas.detail', ['id' => 3]) }}" class="card-modern p-5 block hover:shadow-xl transition">
            <div class="flex items-start justify-between mb-3">
                <span class="inline-flex items-center gap-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                    Rendah
                </span>
                <span class="text-gray-500 text-sm">12 hari lagi</span>
            </div>
            
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                Essay Bahasa Inggris
            </h3>
            
            <div class="space-y-1 text-gray-600 text-sm">
                <div class="flex items-center gap-2">
                    <span>⏰</span>
                    <span>5 November 2025, 23:59</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>📚</span>
                    <span>English for Academic Purposes</span>
                </div>
            </div>
        </a>
        
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">📝</div>
            <div class="text-3xl font-bold mb-1">12</div>
            <div class="text-sm opacity-90">Total Tugas Aktif</div>
        </div>
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">✅</div>
            <div class="text-3xl font-bold mb-1">8</div>
            <div class="text-sm opacity-90">Selesai Minggu Ini</div>
        </div>
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">🔥</div>
            <div class="text-3xl font-bold mb-1">3</div>
            <div class="text-sm opacity-90">Tugas Urgent</div>
        </div>
    </div>
</div>
@endsection