@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center gap-2 text-white hover:text-white/80 mb-6 transition">
        <span>←</span>
        <span class="font-medium">Kembali ke Dashboard</span>
    </a>
    
    <!-- Task Card -->
    <div class="card-modern p-8">
        <!-- Title with Underline (Emphasis) -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6 pb-4 border-b-4 border-purple-600">
            {{ $task->title }}
        </h1>
        
        <div class="space-y-6">
            <!-- Mata Kuliah -->
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📚</span>
                    <span>Mata Kuliah:</span>
                </div>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $task->course }}
                </div>
            </div>
            
            <!-- Dosen -->
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>👤</span>
                    <span>Dosen:</span>
                </div>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $task->lecturer }}
                </div>
            </div>
            
            <!-- Deadline (EMPHASIS) -->
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>⏰</span>
                    <span>Deadline:</span>
                </div>
                <div class="text-xl font-bold text-red-600">
                    {{ $task->deadline }}
                </div>
                <div class="text-sm text-red-500 mt-1">
                    ({{ $task->days_left }} hari lagi)
                </div>
            </div>
            
            <!-- Deskripsi -->
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📝</span>
                    <span>Deskripsi:</span>
                </div>
                <div class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                    {{ $task->description }}
                </div>
            </div>
            
            <!-- Lampiran -->
            @if($task->attachment)
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📎</span>
                    <span>Lampiran:</span>
                </div>
                <a href="#" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg transition">
                    <span>📄</span>
                    <span class="font-medium">{{ $task->attachment }}</span>
                </a>
            </div>
            @endif
            
            <!-- Status -->
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📊</span>
                    <span>Status:</span>
                </div>
                <span class="status-orange">
                    <span>⭕</span>
                    <span>Belum Selesai</span>
                </span>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 pt-6 border-t">
            <button class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition">
                ✅ Tandai Selesai
            </button>
            <button class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl transition">
                ✏️ Edit Tugas
            </button>
        </div>
    </div>
</div>
@endsection