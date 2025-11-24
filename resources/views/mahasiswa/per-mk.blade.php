@extends('layouts.app')

@section('title', 'Per Mata Kuliah')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-8">📚 Tugas per Mata Kuliah</h1>
    
    <!-- HMW 4 - PROXIMITY: Jarak besar antar grup, kecil dalam grup -->
    <div class="space-y-8"> <!-- 32px spacing antar grup -->
        
        @foreach($courses as $course)
        <div class="card-modern p-6 mk-card"> <!-- mk-card = margin-bottom: 28px -->
            <!-- Header Mata Kuliah -->
            <div class="flex items-center gap-3 mb-4 pb-4 border-b-2 border-gray-100">
                <span class="text-3xl">{{ $course->icon }}</span>
                <h2 class="text-xl font-bold text-gray-800">{{ $course->name }}</h2>
            </div>
            
            <!-- Tasks List (PROXIMITY: spacing kecil) -->
            <div class="space-y-1"> <!-- Spacing kecil dalam grup -->
                @foreach($course->tasks as $task)
                <div class="task-item flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 mt-1">•</span>
                        <div>
                            <div class="font-medium text-gray-800">{{ $task['title'] }}</div>
                            <div class="text-sm text-gray-500">Deadline: {{ $task['deadline'] }}</div>
                        </div>
                    </div>
                    <button class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                        Detail →
                    </button>
                </div>
                @endforeach
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Progress</span>
                    <span class="text-sm font-bold text-purple-600">{{ $course->progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full transition-all duration-500" style="width: {{ $course->progress }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
    
    <!-- Summary Card -->
    <div class="card-modern p-6 mt-8 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <h3 class="text-xl font-bold mb-4">📊 Ringkasan</h3>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <div class="text-3xl font-bold">{{ count($courses) }}</div>
                <div class="text-sm opacity-90">Mata Kuliah</div>
            </div>
            <div>
                <div class="text-3xl font-bold">12</div>
                <div class="text-sm opacity-90">Total Tugas</div>
            </div>
            <div>
                <div class="text-3xl font-bold">60%</div>
                <div class="text-sm opacity-90">Rata-rata Progress</div>
            </div>
        </div>
    </div>
</div>
@endsection