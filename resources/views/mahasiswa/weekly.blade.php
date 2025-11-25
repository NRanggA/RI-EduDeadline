@extends('layouts.app')

@section('title', 'Overview Mingguan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header with Navigation -->
    <div class="card-modern p-6 mb-6">
        <div class="flex items-center justify-between">
            <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                <span class="text-2xl">◀</span>
            </button>
            <h1 class="text-2xl font-bold text-gray-800">
                📅 Minggu 16-22 Oktober
            </h1>
            <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                <span class="text-2xl">▶</span>
            </button>
        </div>
    </div>
    
    <!-- Days List -->
    <div class="space-y-4">
        @foreach($days as $day)
        <div class="card-modern p-5 {{ isset($day->heavy) ? 'border-4 border-red-500 bg-red-50' : '' }}">
            <div class="flex items-center gap-3 mb-4">
                <h2 class="text-lg font-bold text-gray-800">{{ $day->day }}</h2>
                @if(isset($day->heavy))
                <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                    🔴 PADAT
                </span>
                @endif
            </div>
            
            @if(count($day->tasks) > 0)
            <div class="space-y-2 pl-4 border-l-2 border-gray-200">
                @foreach($day->tasks as $task)
                <div class="text-gray-700 py-1">
                    {{ $task }}
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center text-gray-400 italic py-3">
                (Tidak ada tugas)
            </div>
            @endif
        </div>
        @endforeach
    </div>
    
    <!-- Summary Footer -->
    <div class="card-modern p-6 mt-6 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-center">
        <div class="text-xl font-bold mb-2">Beban minggu ini: TINGGI ⚠️</div>
        <div class="text-sm opacity-90">7 tugas | 3 hari padat</div>
    </div>
</div>
@endsection