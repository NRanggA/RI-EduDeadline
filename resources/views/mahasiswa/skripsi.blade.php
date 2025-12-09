@extends('layouts.app')

@section('title', 'Dashboard Skripsi')

@section('content')
<div class="flex flex-col items-center justify-start pt-4 pb-8 bg-gradient-to-b from-white to-gray-50 min-h-screen">

    <!-- Main Content Container -->
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Research Title Section -->
        <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 font-semibold mb-2">Judul Penelitian</div>
            <div class="text-lg font-bold text-gray-800">{{ $thesis->title ?? 'Judul Skripsi' }}</div>
        </div>

        <!-- Progress Section -->
        <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
            <div class="text-sm text-gray-500 font-semibold mb-4">Progress Bab:</div>
            
            @php
                $defaultChapters = [
                    'Bab 1' => 'Pendahuluan',
                    'Bab 2' => 'Tinjauan Pustaka',
                    'Bab 3' => 'Metodologi',
                    'Bab 4' => 'Hasil dan Pembahasan',
                    'Bab 5' => 'Kesimpulan dan Saran',
                ];
                
                $submittedChapters = $submissions->pluck('chapter')->toArray();
            @endphp

            @forelse($defaultChapters as $chapterKey => $chapterName)
                <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0 last:pb-0 last:mb-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-800">{{ $chapterKey }}</h3>
                        <div class="flex items-center gap-2">
                            @if(in_array($chapterKey, $submittedChapters))
                                @php
                                    $submission = $submissions->firstWhere('chapter', $chapterKey);
                                    $status = $submission->status ?? 'submitted';
                                @endphp
                                @if($status === 'approved')
                                    <div class="text-xl">✅</div>
                                @elseif($status === 'rejected')
                                    <span class="text-sm text-red-600">Ditolak</span>
                                    <span class="text-xl">❌</span>
                                @else
                                    <span class="text-sm text-amber-600">In Review</span>
                                    <span class="text-xl">⏳</span>
                                @endif
                            @else
                                <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center bg-white"></div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-sm">Belum ada data bab</p>
            @endforelse
        </div>

        <!-- Deadline Section -->
        @if($thesis->defense_deadline)
            <div class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white rounded-xl p-6 text-center shadow-lg">
                <div class="text-xs font-semibold opacity-90 mb-2 tracking-wide">DEADLINE SIDANG</div>
                <div class="text-3xl font-bold">{{ $thesis->defense_deadline->format('d F Y') }}</div>
                <div class="text-sm opacity-75 mt-2">{{ $thesis->defense_deadline->diffForHumans() }}</div>
            </div>
        @else
            <div class="bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl p-6 text-center shadow-lg">
                <div class="text-xs font-semibold opacity-90 mb-2 tracking-wide">DEADLINE SIDANG</div>
                <div class="text-3xl font-bold">Belum dijadwalkan</div>
            </div>
        @endif

        <!-- Unresolved Feedback Alert -->
        @if($unresolvedFeedback > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <p class="font-semibold text-red-800">{{ $unresolvedFeedback }} Feedback Belum Direspon</p>
                        <p class="text-sm text-red-600 mt-1">Ada feedback dari pembimbing yang memerlukan respons Anda</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions Section -->
        <div class="space-y-2">
            <a href="{{ route('mahasiswa.focus-mode') }}" class="w-full bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-sm flex items-center justify-center gap-2 block">
                <span class="text-lg">🎯</span>
                <span>Focus Mode</span>
            </a>
            <a href="{{ route('mahasiswa.upload-bab') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-sm flex items-center justify-center gap-2">
                <span class="material-icons text-sm">upload</span>
                <span>Upload Bab Terbaru</span>
            </a>
            <a href="{{ route('mahasiswa.feedback') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <span class="material-icons text-sm">feedback</span>
                <span>Lihat Feedback Pembimbing</span>
            </a>
            <a href="{{ route('mahasiswa.schedule') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <span class="material-icons text-sm">event</span>
                <span>Jadwal Sidang</span>
            </a>
        </div>

    </div>
</div>

@endsection
