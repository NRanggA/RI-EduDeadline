@extends('layouts.app')

@section('title', 'Dashboard Skripsi')

@section('content')
<div class="flex flex-col items-center justify-start pt-4 pb-8 bg-gradient-to-b from-white to-gray-50 min-h-screen">

    <!-- Main Content Container -->
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Research Title Section -->
        <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 font-semibold mb-2">Judul Penelitian</div>
            <div class="text-lg font-bold text-gray-800">Sistem Rekomendasi E-Commerce</div>
        </div>

        <!-- Progress Section -->
        <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 font-semibold mb-4">Progress Bab:</div>
            
            <!-- Bab 1 - Completed -->
            <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0 last:mb-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">Bab 1</h3>
                    <div class="text-xl">✅</div>
                </div>
            </div>

            <!-- Bab 2 - Completed -->
            <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0 last:mb-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">Bab 2</h3>
                    <div class="text-xl">✅</div>
                </div>
            </div>

            <!-- Bab 3 - In Progress -->
            <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0 last:mb-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-800">Bab 3</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">In Progress</span>
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
            </div>

            <!-- Bab 4 - Not Started -->
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-800">Bab 4</h3>
                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white"></div>
            </div>
        </div>

        <!-- Deadline Section -->
        <div class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white rounded-xl p-6 text-center shadow-lg">
            <div class="text-xs font-semibold opacity-90 mb-2 tracking-wide">DEADLINE SIDANG</div>
            <div class="text-3xl font-bold">15 Desember 2025</div>
        </div>

        <!-- Actions Section -->
        <div class="space-y-2">
            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-sm flex items-center justify-center gap-2">
                <span class="material-icons text-sm">upload</span>
                <span>Upload Bab Terbaru</span>
            </button>
            <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <span class="material-icons text-sm">feedback</span>
                <span>Lihat Feedback Pembimbing</span>
            </button>
            <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <span class="material-icons text-sm">event</span>
                <span>Jadwal Sidang</span>
            </button>
        </div>

    </div>
</div>

@endsection
