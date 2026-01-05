@extends('layouts.app')

@section('title', 'Per Mata Kuliah')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">📚 Tugas per Mata Kuliah</h1>
        
        <!-- Filter Mata Kuliah -->
        @if(count($courses) > 0)
        <div class="relative">
            <select id="courseFilter" onchange="filterCourse(this.value)" 
                    class="appearance-none bg-white text-gray-800 px-4 py-2 pr-8 rounded-lg border border-gray-300 focus:outline-none focus:border-purple-500 transition cursor-pointer font-medium">
                <option value="">Semua Mata Kuliah</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
        @endif
    </div>
    
    <!-- HMW 4 - PROXIMITY: Jarak besar antar grup, kecil dalam grup -->
    <div class="space-y-8" id="coursesContainer"> <!-- 32px spacing antar grup -->
        
        @forelse($courses as $course)
        <div class="card-modern p-6 mk-card course-card" data-course-id="{{ $course->id }}"> <!-- mk-card = margin-bottom: 28px -->
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

@section('scripts')
<script>
function filterCourse(courseId) {
    const courseCards = document.querySelectorAll('.course-card');
    const emptyState = document.querySelector('[data-empty-state]');
    
    if (!courseId) {
        // Tampilkan semua
        courseCards.forEach(card => {
            card.style.display = '';
            card.classList.add('animate-fadeIn');
        });
        if (emptyState) emptyState.style.display = 'none';
    } else {
        // Filter berdasarkan course_id
        let hasVisible = false;
        courseCards.forEach(card => {
            if (card.dataset.courseId === courseId) {
                card.style.display = '';
                card.classList.add('animate-fadeIn');
                hasVisible = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Tampilkan pesan kosong jika tidak ada yang cocok
        if (emptyState) {
            emptyState.style.display = hasVisible ? 'none' : '';
        }
    }
}
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}
</style>
@endsection