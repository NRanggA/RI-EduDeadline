@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">
            👋 Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-white/80">Hari ini kamu punya <strong>{{ $urgentCount }}</strong> tugas mendesak</p>
    </div>
    
    <!-- Filter Bar -->
    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-4 mb-6 flex flex-wrap gap-3">
        <form id="filterForm" method="GET" action="{{ route('mahasiswa.dashboard') }}" class="flex flex-wrap gap-3 w-full">
            <select name="priority" id="priorityFilter" class="px-4 py-2 rounded-lg border-0 bg-white text-gray-700 font-medium cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Tugas</option>
                <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="rendah" {{ request('priority') === 'rendah' ? 'selected' : '' }}>Rendah</option>
            </select>
            
            <select name="range" id="rangeFilter" class="px-4 py-2 rounded-lg border-0 bg-white text-gray-700 font-medium cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                <option value="3days" {{ request('range') === '3days' ? 'selected' : '' }}>3 Hari</option>
                <option value="month" {{ request('range') === 'month' || !request('range') ? 'selected' : '' }}>Bulan Ini</option>
                <option value="all" {{ request('range') === 'all' ? 'selected' : '' }}>Semua</option>
            </select>
            
            <button type="button" onclick="resetFilters()" class="px-4 py-2 rounded-lg bg-white/50 text-white font-medium cursor-pointer hover:bg-white/70 transition">
                🔄 Reset
            </button>
        </form>
        
        <button onclick="openAddTaskModal()" class="ml-auto px-6 py-2 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
            + Tambah Tugas
        </button>
    </div>
    
    <!-- Tasks Grid -->
    <div class="grid grid-cols-1 gap-5">
        @forelse($upcomingTasks as $task)
        <!-- Task Card -->
        <a href="{{ route('mahasiswa.tugas.detail', ['id' => $task->id]) }}" 
           class="card-modern {{ $task->priority === 'urgent' ? 'card-urgent' : '' }} p-6 block hover:shadow-xl transition">
            <div class="flex items-start justify-between mb-4">
                @if($task->priority === 'urgent')
                    <span class="inline-flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold">
                        <span>🔴</span>
                        <span>URGENT!</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                        {{ ucfirst($task->priority) }}
                    </span>
                @endif
                <span class="text-gray-500 text-sm">
                    @if($task->days_remaining == 0)
                        Hari ini!
                    @elseif($task->days_remaining < 0)
                        {{ abs($task->days_remaining) }} hari yang lalu
                    @else
                        {{ $task->days_remaining }} hari lagi
                    @endif
                </span>
            </div>
            
            <h3 class="text-2xl font-bold {{ $task->priority === 'urgent' ? 'text-red-600' : 'text-gray-800' }} mb-3">
                {{ $task->title }}
            </h3>
            
            <div class="space-y-2 text-gray-700">
                <div class="flex items-center gap-2">
                    <span>⏰</span>
                    <span class="font-semibold">{{ $task->deadline->format('d M Y H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>👤</span>
                    <span>{{ $task->creator->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span>📚</span>
                    <span>{{ $task->course->name }}</span>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ Str::limit($task->description, 50) }}</span>
                <span class="text-purple-600 font-semibold">Lihat Detail →</span>
            </div>
        </a>
        @empty
        <!-- Empty State -->
        <div class="card-modern p-8 text-center">
            <div class="text-5xl mb-4">🎉</div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                @if(request('range') === '3days')
                    Tidak ada tugas untuk 3 hari ke depan
                @elseif(request('range') === 'all')
                    Tidak ada tugas sama sekali
                @else
                    Tidak ada tugas untuk bulan ini
                @endif
            </h3>
            <p class="text-gray-600">Kamu bisa santai sekarang!</p>
        </div>
        @endforelse
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">📝</div>
            <div class="text-3xl font-bold mb-1">{{ $totalTasks }}</div>
            <div class="text-sm opacity-90">Total Tugas Aktif</div>
        </div>
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">✅</div>
            <div class="text-3xl font-bold mb-1">{{ $completedThisWeek }}</div>
            <div class="text-sm opacity-90">Selesai Minggu Ini</div>
        </div>
        <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 text-white">
            <div class="text-3xl mb-2">🔥</div>
            <div class="text-3xl font-bold mb-1">{{ $urgentCount }}</div>
            <div class="text-sm opacity-90">Tugas Urgent</div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tugas -->
<div id="addTaskModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-2xl w-full max-h-96 overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Tugas Baru</h2>
        
        <form action="{{ route('mahasiswa.tugas.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mata Kuliah</label>
                <input type="text" name="course_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" placeholder="Masukkan nama mata kuliah" required>
                @error('course_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Tugas</label>
                <input type="text" name="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" placeholder="Masukkan judul tugas" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" placeholder="Masukkan deskripsi tugas" required></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                    <input type="datetime-local" name="deadline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" required>
                    @error('deadline')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                    <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" required>
                        <option value="rendah">Rendah</option>
                        <option value="normal" selected>Normal</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeAddTaskModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-lg transition">
                    Tambah Tugas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddTaskModal() {
    document.getElementById('addTaskModal').classList.remove('hidden');
}

function closeAddTaskModal() {
    document.getElementById('addTaskModal').classList.add('hidden');
}

function resetFilters() {
    document.getElementById('priorityFilter').value = '';
    document.getElementById('rangeFilter').value = '3days';
    document.getElementById('filterForm').submit();
}

// Close modal when clicking outside
document.getElementById('addTaskModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddTaskModal();
    }
});
</script>
@endsection