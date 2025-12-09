@extends('layouts.app')

@section('title', 'Focus Mode')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-b from-white to-gray-50 px-4 py-8">
    
    <!-- Main Focus Mode Card -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 space-y-8">
        
        <!-- Title -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900">Focus Mode</h1>
        </div>
        
        <!-- Task Info Section -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 space-y-4 border border-purple-200">
            <div class="text-center">
                <p class="text-gray-600 text-sm mb-2">Sedang Mengerjakan:</p>
                <h2 class="text-2xl font-bold text-gray-900">{{ $thesis->title ?? 'Skripsi Saya' }}</h2>
                <p class="text-sm text-gray-600 mt-2">Status: <strong>{{ ucfirst($thesis->status) }}</strong></p>
            </div>
            
            <!-- Timer Display -->
            <div class="text-center py-4">
                <div class="text-5xl font-bold text-purple-600 font-mono" id="timerDisplay">0:00:00</div>
                <p class="text-xs text-gray-500 mt-2" id="sessionTime"></p>
            </div>
            
            <!-- Deadline -->
            @if($thesis->defense_deadline)
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Deadline: {{ $thesis->defense_deadline->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $thesis->defense_deadline->diffForHumans() }}</p>
                </div>
            @endif
        </div>
        
        <!-- Buttons Section -->
        <div class="space-y-4">
            <!-- Start/Stop Timer Button -->
            <button id="timerToggleBtn" onclick="toggleTimer()" class="w-full py-4 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-bold text-lg rounded-xl transition transform hover:scale-105 active:scale-95 shadow-lg">
                Mulai Timer
            </button>
            
            <!-- Exit Focus Mode Button -->
            <a href="{{ route('mahasiswa.skripsi') }}" class="block w-full py-4 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold text-lg rounded-xl transition text-center">
                Keluar Focus
            </a>
        </div>

        <!-- Stats -->
        <div class="space-y-2 text-center text-sm">
            <p class="text-gray-600">📊 <span id="totalTime">0 jam 0 menit</span></p>
            <p class="text-gray-600">✅ Tetap fokus dan selesaikan skripsi Anda</p>
        </div>
        
    </div>
    
    <!-- Info Text -->
    <div class="text-center mt-8 max-w-md">
        <p class="text-gray-600 text-sm">
            💡 Fokus penuh tanpa gangguan. Tetap semangat menyelesaikan tugas!
        </p>
    </div>
    
</div>

<script>
    let timerInterval = null;
    let seconds = 0;
    let isRunning = false;
    
    function updateTimerDisplay() {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        
        const display = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        document.getElementById('timerDisplay').textContent = display;
        
        // Update total time
        const totalMinutes = Math.floor(seconds / 60);
        const totalHours = Math.floor(totalMinutes / 60);
        const remainingMinutes = totalMinutes % 60;
        
        if (totalHours > 0) {
            document.getElementById('totalTime').textContent = `${totalHours} jam ${remainingMinutes} menit`;
        } else {
            document.getElementById('totalTime').textContent = `${remainingMinutes} menit`;
        }
        
        // Update session time
        const now = new Date().toLocaleTimeString('id-ID');
        document.getElementById('sessionTime').textContent = `Session: ${now}`;
    }
    
    function toggleTimer() {
        const btn = document.getElementById('timerToggleBtn');
        
        if (isRunning) {
            // Stop timer
            clearInterval(timerInterval);
            isRunning = false;
            btn.textContent = 'Mulai Timer';
            btn.classList.remove('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
            btn.classList.add('from-purple-500', 'to-blue-500', 'hover:from-purple-600', 'hover:to-blue-600');
        } else {
            // Start timer
            isRunning = true;
            btn.textContent = 'STOP';
            btn.classList.remove('from-purple-500', 'to-blue-500', 'hover:from-purple-600', 'hover:to-blue-600');
            btn.classList.add('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
            
            timerInterval = setInterval(() => {
                seconds++;
                updateTimerDisplay();
            }, 1000);
        }
    }
    
    // Initialize display
    updateTimerDisplay();
</script>

@endsection
