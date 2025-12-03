@extends('layouts.app')

@section('title', 'Timeline Skripsi')

@section('content')
<div class="flex flex-col items-center justify-start min-h-screen pt-4 pb-8 bg-gradient-to-b from-white to-gray-50">

    <!-- Main Content -->
    <div class="w-full max-w-2xl mx-auto px-4">
        
        <!-- Timeline Progress Indicator -->
        <div class="mb-12">
            <div class="flex justify-between items-end gap-2 px-2 mb-6">
                <!-- Bab 1 -->
                <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-green-500 text-white flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                        ✓
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-700 text-center">Bab 1</span>
                </div>

                <!-- Connector 1-2 -->
                <div class="flex-1 h-1 bg-green-500 mb-6 rounded"></div>

                <!-- Bab 2 -->
                <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-green-500 text-white flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                        ✓
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-700 text-center">Bab 2</span>
                </div>

                <!-- Connector 2-3 -->
                <div class="flex-1 h-1 bg-yellow-500 mb-6 rounded"></div>

                <!-- Bab 3 -->
                <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-yellow-500 text-white flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                        ⏳
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-700 text-center">Bab 3</span>
                </div>

                <!-- Connector 3-4 -->
                <div class="flex-1 h-1 bg-gray-300 mb-6 rounded"></div>

                <!-- Bab 4 -->
                <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-3 border-gray-300 text-gray-400 flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                        ○
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-700 text-center">Bab 4</span>
                </div>

                <!-- Connector 4-5 -->
                <div class="flex-1 h-1 bg-gray-300 mb-6 rounded"></div>

                <!-- Bab 5 -->
                <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-3 border-gray-300 text-gray-400 flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                        ○
                    </div>
                    <span class="text-xs md:text-sm font-bold text-gray-700 text-center">Bab 5</span>
                </div>
            </div>
        </div>

        <!-- Active Tasks Section -->
        <div class="mb-8">
            <h2 class="text-gray-400 text-sm font-semibold mb-4 text-center">Tugas Kuliah Aktif:</h2>
            
            <div class="space-y-4">
                <!-- Task 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition border-l-4 border-yellow-500">
                    <h3 class="text-lg font-bold text-gray-800">Metodologi Penelitian</h3>
                    <div class="mt-2 text-xs text-gray-500">
                        <p>📅 Deadline: 10 Desember 2025</p>
                        <p>👤 Dosen: Dr. Siti Nurhaliza</p>
                        <p>📚 Matakuliah: Metodologi Penelitian</p>
                    </div>
                </div>

                <!-- Task 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition border-l-4 border-orange-400">
                    <h3 class="text-lg font-bold text-gray-800">Seminar Proposal</h3>
                    <div class="mt-2 text-xs text-gray-500">
                        <p>📅 Deadline: 12 Desember 2025</p>
                        <p>👤 Dosen: Prof. Bambang Suryanto</p>
                        <p>📚 Matakuliah: Seminar Proposal</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Spacing -->
        <div class="h-4"></div>
    </div>
</div>

@endsection
