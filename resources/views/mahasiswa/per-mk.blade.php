@extends('layouts.app')

@section('title', 'Per Mata Kuliah')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-white mb-8">📚 Tugas per Mata Kuliah</h1>
    
    <!-- HMW 4 - PROXIMITY: Jarak besar antar grup, kecil dalam grup -->
    <div class="space-y-8"> <!-- 32px spacing antar grup -->
        
        @forelse($courses as $course)
        <div class="card-modern p-6 mk-card"> <!-- mk-card = margin-bottom: 28px -->
            <!-- Header Mata Kuliah -->
            <div class="flex items-center gap-3 mb-4 pb-4 border-b-2 border-gray-100">
                <span class="text-3xl">{{ $course->icon }}</span>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-800">{{ $course->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $course->code }}</p>
                </div>
            </div>
            
            <!-- Tasks List (PROXIMITY: spacing kecil) -->
            @if(count($course->tasks) > 0)
            <div class="space-y-1"> <!-- Spacing kecil dalam grup -->
                @foreach($course->tasks as $task)
                <a href="{{ route('mahasiswa.tugas.detail', ['id' => $task['id']]) }}" 
                   class="task-item flex items-center justify-between py-3 px-3 rounded hover:bg-gray-50 border-b border-gray-50 last:border-0 transition">
                    <div class="flex items-start gap-3 flex-1">
                        <span class="text-{{ $task['priority'] === 'urgent' ? 'red' : 'gray' }}-400 mt-1">
                            @if($task['priority'] === 'urgent')
                                🔴
                            @elseif($task['priority'] === 'normal')
                                🟡
                            @else
                                🟢
                            @endif
                        </span>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">{{ $task['title'] }}</div>
                            <div class="text-sm text-gray-500">Deadline: {{ $task['deadline'] }}</div>
                        </div>
                    </div>
                    <button class="text-purple-600 hover:text-purple-700 font-medium text-sm whitespace-nowrap ml-4">
                        Detail →
                    </button>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-6">
                <p class="text-gray-600">Tidak ada tugas aktif untuk mata kuliah ini</p>
            </div>
            @endif
            
            <!-- Progress Bar -->
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Progress</span>
                    <span class="text-sm font-bold text-purple-600">{{ round($course->progress) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full transition-all duration-500" 
                         style="width: {{ round($course->progress) }}%"></div>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    {{ $course->completed_tasks }} / {{ $course->total_tasks }} tugas selesai
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="card-modern p-8 text-center">
            <div class="text-5xl mb-4">📚</div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada mata kuliah</h3>
            <p class="text-gray-600">Kamu akan melihat mata kuliah yang sudah diambil di sini</p>
        </div>
        @endforelse
        
    </div>
    
    <!-- Summary Card -->
    @if(count($courses) > 0)
    <div class="card-modern p-6 mt-8 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <h3 class="text-xl font-bold mb-4">📊 Ringkasan</h3>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <div class="text-3xl font-bold">{{ count($courses) }}</div>
                <div class="text-sm opacity-90">Mata Kuliah</div>
            </div>
            <div>
                <div class="text-3xl font-bold">
                    @php
                        $totalTasks = collect($courses)->sum(function($c) { return $c->total_tasks; });
                    @endphp
                    {{ $totalTasks }}
                </div>
                <div class="text-sm opacity-90">Total Tugas</div>
            </div>
            <div>
                <div class="text-3xl font-bold">
                    @php
                        $avgProgress = count($courses) > 0 ? round(collect($courses)->avg('progress')) : 0;
                    @endphp
                    {{ $avgProgress }}%
                </div>
                <div class="text-sm opacity-90">Rata-rata Progress</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection