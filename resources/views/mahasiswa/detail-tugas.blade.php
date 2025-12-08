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
                <div class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <span>{{ $task->course->icon ?? '📘' }}</span>
                    {{ $task->course->name }}
                </div>
            </div>
            
            <!-- Dosen -->
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>👤</span>
                    <span>Dosen:</span>
                </div>
                <div class="text-lg font-semibold text-gray-800">
                    {{ $task->creator->name }}
                </div>
            </div>
            
            <!-- Deadline (EMPHASIS) -->
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>⏰</span>
                    <span>Deadline:</span>
                </div>
                <div class="text-xl font-bold text-red-600">
                    {{ $task->deadline->format('d M Y H:i') }}
                </div>
                <div class="text-sm text-red-500 mt-1">
                    ({{ $task->days_remaining }} hari lagi)
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
            
            <!-- Notes -->
            @if($task->notes)
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📌</span>
                    <span>Catatan:</span>
                </div>
                <div class="text-gray-700 leading-relaxed bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                    {{ $task->notes }}
                </div>
            </div>
            @endif
            
            <!-- Lampiran -->
            @if($task->attachment_path)
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📎</span>
                    <span>Lampiran:</span>
                </div>
                <a href="{{ $task->attachment_path }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-3 rounded-lg transition">
                    <span>📄</span>
                    <span class="font-medium">{{ basename($task->attachment_path) }}</span>
                </a>
            </div>
            @endif
            
            <!-- Status Pengumpulan -->
            @if($completion)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📊</span>
                    <span>Status Pengumpulan:</span>
                </div>
                <div class="flex items-center gap-2">
                    @if($completion->status === 'pending')
                        <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                            <span>⏳</span>
                            <span>Pending</span>
                        </span>
                    @elseif($completion->status === 'submitted')
                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                            <span>🟡</span>
                            <span>Sudah Dikumpulkan</span>
                        </span>
                    @elseif($completion->status === 'approved')
                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            <span>✅</span>
                            <span>Disetujui</span>
                        </span>
                    @elseif($completion->status === 'rejected')
                        <span class="inline-flex items-center gap-2 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                            <span>❌</span>
                            <span>Ditolak</span>
                        </span>
                    @endif
                </div>
                @if($completion->submission_notes)
                <div class="mt-3 text-sm text-gray-700">
                    <p class="font-medium mb-1">Catatan:</p>
                    <p>{{ $completion->submission_notes }}</p>
                </div>
                @endif
            </div>
            @else
            <div>
                <div class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                    <span>📊</span>
                    <span>Status:</span>
                </div>
                <span class="inline-flex items-center gap-2 bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                    <span>⭕</span>
                    <span>Belum Dikumpulkan</span>
                </span>
            </div>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 pt-6 border-t">
            @if(!$completion || $completion->status === 'pending')
            <form action="{{ route('mahasiswa.tugas.complete', ['id' => $task->id]) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition">
                    ✅ Tandai Selesai
                </button>
            </form>
            @else
            <div class="flex-1 bg-green-100 text-green-800 font-bold py-4 rounded-xl text-center">
                ✅ Sudah Dikumpulkan
            </div>
            @endif
            
            @if(!$completion || ($completion->status !== 'approved' && $completion->status !== 'rejected'))
            <button type="button" onclick="openEditModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-xl transition">
                ✏️ Edit Tugas
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Edit Tugas -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Edit Tugas</h2>
        
        <form action="{{ route('mahasiswa.tugas.update', ['id' => $task->id]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Tugas</label>
                <input type="text" name="title" value="{{ $task->title }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" required>{{ $task->description }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                <input type="datetime-local" name="deadline" value="{{ $task->deadline->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                    <option value="rendah" {{ $task->priority === 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="normal" {{ $task->priority === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="urgent" {{ $task->priority === 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>
@endsection