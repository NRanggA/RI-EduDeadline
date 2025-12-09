@extends('layouts.app')

@section('title', 'Jadwal Sidang')

@section('content')
<div class="flex flex-col items-center justify-start pt-4 pb-8 bg-gradient-to-b from-white to-gray-50 min-h-screen">

    <!-- Main Content Container -->
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('mahasiswa.skripsi') }}" class="text-gray-600 hover:text-gray-900">
                <span class="material-icons">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Jadwal Sidang</h1>
        </div>

        @if(!$schedule)
            <!-- Empty State -->
            <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-100 text-center">
                <p class="text-5xl mb-3">📅</p>
                <p class="text-gray-600 font-medium">Jadwal belum ditentukan</p>
                <p class="text-sm text-gray-500 mt-2">Jadwal sidang akan ditampilkan di sini setelah dikonfirmasi oleh pembimbing</p>
            </div>
        @else
            <!-- Schedule Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                
                <!-- Status Badge -->
                <div class="bg-gradient-to-r {{ $schedule->status === 'completed' ? 'from-green-400 to-green-500' : 'from-blue-400 to-blue-500' }} text-white px-4 py-2 text-center text-sm font-semibold">
                    {{ $schedule->status === 'scheduled' ? '📅 Terjadwal' : ($schedule->status === 'ongoing' ? '⏳ Sedang Berlangsung' : '✅ Selesai') }}
                </div>

                <div class="p-6 space-y-6">
                    
                    <!-- Date & Time -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">📆</div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 font-semibold mb-1">TANGGAL SIDANG</p>
                                <p class="text-xl font-bold text-gray-800">{{ $schedule->defense_date->format('d MMMM Y', \Carbon\Carbon::setLocale('id')) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time -->
                    <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                        <div class="text-3xl">🕐</div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 font-semibold mb-1">JAM SIDANG</p>
                            <p class="text-xl font-bold text-gray-800">{{ $schedule->defense_time }}</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">📍</div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 font-semibold mb-1">LOKASI</p>
                            <p class="text-lg font-bold text-gray-800">{{ $schedule->location }}</p>
                            @if($schedule->room)
                                <p class="text-sm text-gray-600 mt-1">Ruangan: <strong>{{ $schedule->room }}</strong></p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Advisors & Examiners -->
            <div class="space-y-4">
                
                <!-- Advisor -->
                @if($thesis->advisor)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-3">👨‍🏫 PEMBIMBING UTAMA</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($thesis->advisor->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $thesis->advisor->name }}</p>
                                <p class="text-xs text-gray-600">{{ $thesis->advisor->email ?? 'Dosen' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Co-Advisor -->
                @if($thesis->coAdvisor)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-3">👨‍🏫 PEMBIMBING KEDUA</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($thesis->coAdvisor->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $thesis->coAdvisor->name }}</p>
                                <p class="text-xs text-gray-600">{{ $thesis->coAdvisor->email ?? 'Dosen' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Examiners -->
                @if($schedule->examiner1)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-3">🧑‍⚖️ PENGUJI 1</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($schedule->examiner1->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $schedule->examiner1->name }}</p>
                                <p class="text-xs text-gray-600">{{ $schedule->examiner1->email ?? 'Dosen' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($schedule->examiner2)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 font-semibold mb-3">🧑‍⚖️ PENGUJI 2</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-pink-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($schedule->examiner2->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $schedule->examiner2->name }}</p>
                                <p class="text-xs text-gray-600">{{ $schedule->examiner2->email ?? 'Dosen' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Notes -->
            @if($schedule->notes)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800">
                        <strong>📝 Catatan:</strong> {{ $schedule->notes }}
                    </p>
                </div>
            @endif

            <!-- Countdown -->
            @if($schedule->status === 'scheduled' && $schedule->defense_date->isFuture())
                @php
                    $daysUntil = now()->diffInDays($schedule->defense_date);
                @endphp
                <div class="bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-xl p-6 text-center shadow-lg">
                    <div class="text-xs font-semibold opacity-90 mb-2 tracking-wide">WAKTU TERSISA</div>
                    <div class="text-4xl font-bold">{{ $daysUntil }}</div>
                    <div class="text-sm opacity-75 mt-2">{{ $daysUntil === 1 ? 'hari' : 'hari' }}</div>
                </div>
            @endif

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
