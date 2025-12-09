@extends('layouts.app')

@section('title', 'Timeline Skripsi')

@section('content')
<div class="flex flex-col items-center justify-start min-h-screen pt-4 pb-8 bg-gradient-to-b from-white to-gray-50">

    <!-- Main Content -->
    <div class="w-full max-w-2xl mx-auto px-4">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('mahasiswa.skripsi') }}" class="text-gray-600 hover:text-gray-900">
                <span class="material-icons">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Timeline Skripsi</h1>
        </div>

        <!-- Timeline Progress Indicator -->
        @php
            $defaultChapters = ['Bab 1', 'Bab 2', 'Bab 3', 'Bab 4', 'Bab 5'];
            $submittedChapters = $submissions->pluck('chapter')->toArray();
            $chapterCount = count($defaultChapters);
        @endphp

        <div class="mb-12">
            <div class="flex justify-between items-end gap-2 px-2 mb-6">
                @foreach($defaultChapters as $index => $chapter)
                    @php
                        $isSubmitted = in_array($chapter, $submittedChapters);
                        $submission = $submissions->firstWhere('chapter', $chapter);
                        $status = $submission->status ?? null;
                    @endphp

                    <!-- Chapter Circle -->
                    <div class="flex flex-col items-center gap-2 flex-1 md:flex-initial">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full {{ $isSubmitted ? ($status === 'approved' ? 'bg-green-500' : 'bg-yellow-500') : 'bg-white border-3 border-gray-300' }} text-white flex items-center justify-center text-xl shadow-lg transform hover:scale-110 transition">
                            @if($isSubmitted)
                                @if($status === 'approved')
                                    ✓
                                @elseif($status === 'rejected')
                                    ✕
                                @else
                                    ⏳
                                @endif
                            @else
                                ○
                            @endif
                        </div>
                        <span class="text-xs md:text-sm font-bold text-gray-700 text-center">{{ $chapter }}</span>
                        @if($isSubmitted && $submission)
                            <span class="text-xs text-gray-500">v{{ $submission->version }}</span>
                        @endif
                    </div>

                    <!-- Connector -->
                    @if($index < count($defaultChapters) - 1)
                        <div class="flex-1 h-1 {{ $index < count(collect($submittedChapters)->filter()) ? 'bg-green-500' : ($index == count(collect($submittedChapters)->filter()) ? 'bg-yellow-500' : 'bg-gray-300') }} mb-6 rounded"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Schedule Timeline -->
        @if($schedules->isNotEmpty())
            <div class="space-y-4 mt-12">
                <h2 class="text-lg font-bold text-gray-900 mb-4">📅 Jadwal Sidang</h2>
                
                @foreach($schedules as $schedule)
                    <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 {{ $schedule->status === 'completed' ? 'border-green-500' : 'border-blue-500' }} hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $schedule->defense_date->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    🕐 {{ $schedule->defense_time }} - {{ $schedule->location }}
                                </p>
                                @if($schedule->room)
                                    <p class="text-sm text-gray-600">
                                        📍 Ruangan {{ $schedule->room }}
                                    </p>
                                @endif
                            </div>
                            <span class="text-xs font-semibold {{ $schedule->status === 'completed' ? 'text-green-600 bg-green-100' : 'text-blue-600 bg-blue-100' }} px-3 py-1 rounded-full">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Submission History -->
        <div class="mt-12 space-y-4">
            <h2 class="text-lg font-bold text-gray-900 mb-4">📝 Riwayat Pengumpulan</h2>
            
            @forelse($submissions as $submission)
                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $submission->chapter }} - {{ $submission->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">Versi {{ $submission->version }}</p>
                        </div>
                        <span class="text-xs font-semibold {{ $submission->status === 'approved' ? 'text-green-600 bg-green-100' : ($submission->status === 'rejected' ? 'text-red-600 bg-red-100' : 'text-amber-600 bg-amber-100') }} px-3 py-1 rounded-full">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $submission->created_at->format('d M Y H:i') }}</p>
                    @if($submission->description)
                        <p class="text-sm text-gray-600 mt-2 italic">{{ $submission->description }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <p>Belum ada pengumpulan bab</p>
                </div>
            @endforelse
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('mahasiswa.skripsi') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                Kembali ke Skripsi
            </a>
        </div>

    </div>
</div>

@endsection
