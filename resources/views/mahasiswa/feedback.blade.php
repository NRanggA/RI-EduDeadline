@extends('layouts.app')

@section('title', 'Feedback Pembimbing')

@section('content')
<div class="flex flex-col items-center justify-start pt-4 pb-8 bg-gradient-to-b from-white to-gray-50 min-h-screen">

    <!-- Main Content Container -->
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('mahasiswa.skripsi') }}" class="text-gray-600 hover:text-gray-900">
                <span class="material-icons">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Feedback Pembimbing</h1>
        </div>

        @if($feedbackBySubmission->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-100 text-center">
                <p class="text-5xl mb-3">📝</p>
                <p class="text-gray-600 font-medium">Belum ada feedback</p>
                <p class="text-sm text-gray-500 mt-2">Feedback dari pembimbing akan muncul di sini setelah Anda upload bab</p>
            </div>
        @else
            <!-- Feedback List -->
            @foreach($feedbackBySubmission as $submissionId => $feedbackItems)
                @php
                    $submission = $feedbackItems->first()->submission;
                @endphp
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Submission Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $submission->chapter }}</p>
                                <p class="text-sm text-gray-600">{{ $submission->title }}</p>
                            </div>
                            <span class="text-xs font-semibold {{ $submission->status === 'approved' ? 'text-green-600 bg-green-100' : 'text-amber-600 bg-amber-100' }} px-3 py-1 rounded-full">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Feedback Items -->
                    <div class="space-y-0">
                        @foreach($feedbackItems as $feedback)
                            <div class="p-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition">
                                <!-- Advisor Info -->
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-sm font-semibold">
                                        {{ strtoupper(substr($feedback->advisor->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800 text-sm">{{ $feedback->advisor->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $feedback->created_at->format('d M Y \a\t H:i') }}</p>
                                    </div>
                                    <span class="text-xs font-semibold {{ $feedback->priority === 'high' ? 'text-red-600 bg-red-100' : ($feedback->priority === 'medium' ? 'text-amber-600 bg-amber-100' : 'text-green-600 bg-green-100') }} px-2 py-1 rounded">
                                        {{ ucfirst($feedback->priority) }}
                                    </span>
                                </div>

                                <!-- Feedback Content -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $feedback->feedback }}</p>
                                </div>

                                <!-- Feedback Type -->
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-500">
                                        {{ $feedback->type === 'general' ? '💬 General Feedback' : '📍 Feedback Spesifik' }}
                                        @if($feedback->line_number)
                                            - Baris {{ $feedback->line_number }}
                                        @endif
                                    </span>
                                    <div class="flex items-center gap-2">
                                        @if($feedback->is_resolved)
                                            <span class="text-green-600 font-semibold">✓ Selesai</span>
                                        @else
                                            <form action="{{ route('mahasiswa.feedback.resolve', $feedback->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-700 font-semibold">
                                                    Tandai Selesai
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Download Button -->
                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
                        <a href="{{ route('mahasiswa.chapter.download', $submission->id) }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                            <span class="material-icons text-sm">download</span>
                            Download {{ $submission->chapter }}
                        </a>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Back Button -->
        <div>
            <a href="{{ route('mahasiswa.skripsi') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                Kembali ke Skripsi
            </a>
        </div>

    </div>
</div>

@endsection
