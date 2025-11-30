@extends('layouts.app')

@section('title', 'Kalender')

@section('content')
<div class="flex flex-col items-center justify-start min-h-[80vh] pt-4 pb-8 bg-white">
    <!-- Header -->
    <div class="w-full max-w-md flex items-center justify-between px-4 mb-4">
        <button class="text-2xl text-white bg-transparent border-0 focus:outline-none">
            <span class="material-icons">menu</span>
        </button>
        <div class="font-bold text-xl text-white bg-gradient-to-r from-indigo-400 to-purple-500 px-4 py-2 rounded-lg shadow" style="margin-left:-40px;">Kalender</div>
        <a href="{{ route('mahasiswa.tambah-event') }}" class="text-2xl text-white bg-transparent border-0 focus:outline-none">
            <span class="material-icons">add</span>
        </a>
    </div>
    <!-- Kalender Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 max-w-xs w-full mx-auto mb-6 border border-gray-300" style="min-width:270px;">
        <div class="text-center font-bold text-lg mb-2">Kalender</div>
        <table class="w-full text-center select-none">
            <thead>
                <tr class="text-gray-700">
                    <th class="font-semibold">S</th>
                    <th class="font-semibold">S</th>
                    <th class="font-semibold">R</th>
                    <th class="font-semibold">K</th>
                    <th class="font-semibold">J</th>
                    <th class="font-semibold">S</th>
                    <th class="font-semibold">M</th>
                </tr>
            </thead>
            <tbody>
                @for ($row = 0; $row < 2; $row++)
                <tr>
                    @for ($col = 0; $col < 7; $col++)
                        @php $date = 16 + $row * 7 + $col; @endphp
                        <td class="py-1 px-2">
                            <div class="relative flex flex-col items-center">
                                <span class="font-semibold text-base">{{ $date }}</span>
                                <div class="flex gap-1 mt-1">
                                    @if(isset($calendar[$date]))
                                        @foreach($calendar[$date] as $type)
                                            @if($type === 'kuliah')
                                                <span class="w-2 h-2 rounded-full bg-purple-700 inline-block"></span>
                                            @elseif($type === 'event')
                                                <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block"></span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </td>
                    @endfor
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="flex justify-center gap-4 mt-3 text-sm">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-purple-700 inline-block"></span> Kuliah</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span> Event</span>
        </div>
    </div>
    @if($conflict)
    <div class="bg-red-500 text-white rounded-lg shadow-md px-4 py-3 mb-4 w-full max-w-xs flex flex-col items-start">
        <div class="font-bold text-lg flex items-center gap-2 mb-1"><span class="text-xl">⚠️</span> Bentrok!</div>
        <div class="text-sm">{{ $conflictInfo['date'] }}: 
            @foreach($conflictInfo['items'] as $item)
                {{ $item['type'] }} +
            @endforeach
            Seminar
        </div>
    </div>
    <button class="w-full max-w-xs bg-gray-400 text-white font-bold py-2 rounded-xl shadow mb-2" disabled>HAPUS</button>
    @endif
</div>
@endsection
