@extends('layouts.app')

@section('title', 'Kalender')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold text-white">📅 Kalender</h1>
            <button onclick="openAddEventModal()" class="px-6 py-2 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                + Tambah Event
            </button>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <!-- Month/Year Navigation -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.calendar', ['year' => $prevYear->year, 'month' => $prevYear->month]) }}" 
                   class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-medium">
                    ← {{ $prevYear->format('Y') }}
                </a>
                <a href="{{ route('mahasiswa.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" 
                   class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-medium">
                    ← Bulan Lalu
                </a>
            </div>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800">{{ $currentDate->format('F Y') }}</h2>
                <p class="text-gray-600 text-sm">
                    @if($isCurrentMonth)
                        Hari ini: {{ $today->format('d M Y') }}
                    @endif
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" 
                   class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-medium">
                    Bulan Depan →
                </a>
                <a href="{{ route('mahasiswa.calendar', ['year' => $nextYear->year, 'month' => $nextYear->month]) }}" 
                   class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-medium">
                    {{ $nextYear->format('Y') }} →
                </a>
            </div>
        </div>

        <!-- Calendar Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-center">
                <!-- Header: Days of Week -->
                <thead>
                    <tr class="border-b-2 border-gray-300">
                        <th class="py-4 text-gray-700 font-bold text-sm">S</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">S</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">R</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">K</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">J</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">S</th>
                        <th class="py-4 text-gray-700 font-bold text-sm">M</th>
                    </tr>
                </thead>
                <!-- Calendar Days -->
                <tbody>
                    @php
                        $weekCount = 0;
                        $dayIndex = 0;
                    @endphp
                    @while($weekCount < 6)
                        <tr class="border-b border-gray-200">
                            @for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++)
                                @php
                                    $day = $calendarDays[$dayIndex] ?? null;
                                    $dayIndex++;
                                    $hasData = $day && isset($daysWithData[$day]);
                                    $isToday = $isCurrentMonth && $day === $today->day;
                                    $tasks = $hasData ? $daysWithData[$day]['tasks'] : collect();
                                    $events = $hasData ? $daysWithData[$day]['events'] : collect();
                                    $dayActivities = $day && isset($activities[$day]) ? $activities[$day] : collect();
                                @endphp
                                <td class="h-24 p-2 border-r border-gray-200 @if($dayOfWeek === 6) border-r-0 @endif @if($day) cursor-pointer hover:bg-purple-50 transition @endif"
                                    @if($day) onclick="openAddActivityModal({{ $day }})" @endif>
                                    @if($day)
                                        <div class="h-full flex flex-col">
                                            <div class="font-semibold text-base @if($isToday) text-white bg-purple-600 w-6 h-6 rounded-full flex items-center justify-center @else text-gray-700 @endif">
                                                {{ $day }}
                                            </div>
                                            <div class="flex gap-1 justify-center mt-1 flex-wrap">
                                                @forelse($tasks as $task)
                                                    <span class="w-2 h-2 rounded-full @if($task->priority === 'urgent') bg-red-500 @elseif($task->priority === 'normal') bg-yellow-500 @else bg-blue-500 @endif" title="Task: {{ $task->title }}"></span>
                                                @empty
                                                @endforelse
                                                @forelse($events as $event)
                                                    <span class="w-2 h-2 rounded-full bg-orange-500" title="Event: {{ $event->title }}"></span>
                                                @empty
                                                @endforelse
                                                @forelse($dayActivities as $activity)
                                                    <span class="w-2 h-2 rounded-full @if($activity->category === 'Kuliah') bg-purple-600 @else bg-green-500 @endif" title="{{ $activity->category }}: {{ $activity->name }}"></span>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        @php $weekCount++; @endphp
                    @endwhile
                </tbody>
            </table>
        </div>

        <!-- Legend -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap gap-8 justify-center">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-gray-700 font-medium">Urgent</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    <span class="text-gray-700 font-medium">Normal</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-gray-700 font-medium">Rendah</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                    <span class="text-gray-700 font-medium">Event</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View: Tasks for Current Month -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-white mb-4">📋 Tugas Bulan Ini</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $allMonthTasks = collect($daysWithData)->flatMap(fn($day) => $day['tasks'])->sortBy('deadline');
            @endphp
            @forelse($allMonthTasks as $task)
                <a href="{{ route('mahasiswa.tugas.detail', ['id' => $task->id]) }}" 
                   class="bg-white rounded-lg p-4 hover:shadow-lg transition border-l-4 @if($task->priority === 'urgent') border-red-500 @elseif($task->priority === 'normal') border-yellow-500 @else border-blue-500 @endif">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-gray-800">{{ $task->title }}</h3>
                        <span class="text-xs font-bold px-2 py-1 rounded-full @if($task->priority === 'urgent') bg-red-100 text-red-700 @elseif($task->priority === 'normal') bg-yellow-100 text-yellow-700 @else bg-blue-100 text-blue-700 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                        <span>📅</span>
                        <span>{{ $task->deadline->format('d M Y') }} ({{ $task->days_remaining }} hari)</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>📚</span>
                        <span>{{ $task->course->name }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-2 text-center py-8 text-gray-500">
                    <p>Tidak ada tugas untuk bulan ini</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick View: Events for Current Month -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-white mb-4">🎉 Event Bulan Ini</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $allMonthEvents = collect($daysWithData)->flatMap(fn($day) => $day['events'])->sortBy('start_date');
            @endphp
            @forelse($allMonthEvents as $event)
                <div class="bg-white rounded-lg p-4 border-l-4 border-orange-500 hover:shadow-lg transition">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-gray-800">{{ $event->title }}</h3>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-orange-100 text-orange-700">
                            {{ ucfirst($event->type) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>🕐</span>
                        <span>{{ $event->start_date->format('d M Y H:i') }}</span>
                    </div>
                    @if($event->description)
                        <p class="text-sm text-gray-600 mt-2">{{ $event->description }}</p>
                    @endif
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-gray-500">
                    <p>Tidak ada event untuk bulan ini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal: Add Activity/Kegiatan -->
<div id="addActivityModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-96 overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4">← Tambah Kegiatan</h2>
        
        @if(session('conflict'))
            <!-- Conflict Warning -->
            <div class="bg-red-50 border-4 border-red-500 rounded-lg p-4 mb-4">
                <div class="text-center mb-4">
                    <div class="text-5xl mb-2">⚠️</div>
                    <h3 class="text-lg font-bold text-red-600">PERINGATAN BENTROK</h3>
                </div>
                <div class="space-y-2 mb-4">
                    @foreach(session('conflictActivities', []) as $conflict)
                        <div class="bg-white rounded p-3 border-l-4 border-red-500">
                            <p class="font-bold text-gray-800">{{ $conflict['name'] ?? 'Kegiatan' }}</p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($conflict['date'])->format('d M, H:i') }} - 
                                {{ \Carbon\Carbon::parse($conflict['end_time'])->format('H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="closeAddActivityModal()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                        Ubah
                    </button>
                    <form method="POST" action="{{ route('mahasiswa.activity.store.force') }}" class="flex-1">
                        @csrf
                        @foreach(old() as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Tetap Simpan
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Activity Form -->
            <form action="{{ route('mahasiswa.activity.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Nama Kegiatan*</label>
                    <input type="text" name="name" placeholder="Nama Kegiatan" required value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Kategori*</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 @if(old('category') === 'Kuliah') border-purple-500 bg-purple-50 @endif">
                            <input type="radio" name="category" value="Kuliah" @if(old('category') === 'Kuliah' || !old('category')) checked @endif class="w-4 h-4">
                            <div>
                                <span class="font-bold">🎓 Kuliah</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 @if(old('category') === 'Event Organisasi') border-purple-500 bg-purple-50 @endif">
                            <input type="radio" name="category" value="Event Organisasi" @if(old('category') === 'Event Organisasi') checked @endif class="w-4 h-4">
                            <div>
                                <span class="font-bold">🎯 Event Organisasi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Tanggal & Waktu*</label>
                    <div class="flex gap-2">
                        <input type="date" name="date" id="activityDate" required value="{{ old('date') }}" 
                               class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('date') border-red-500 @enderror">
                        <input type="time" name="start_time" placeholder="Mulai" required value="{{ old('start_time') }}" 
                               class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('start_time') border-red-500 @enderror">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Waktu Selesai & Simpan*</label>
                    <div class="flex gap-2">
                        <input type="time" name="end_time" placeholder="Selesai" required value="{{ old('end_time') }}" 
                               class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('end_time') border-red-500 @enderror">
                        <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                            Simpan
                        </button>
                    </div>
                </div>

                <div>
                    <button type="button" onclick="closeAddActivityModal()" class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                        Ubah
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<!-- Modal: Add Event (existing) -->
<div id="addEventModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h2 class="text-2xl font-bold mb-4">Tambah Event</h2>
        <form action="{{ route('mahasiswa.event.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Event</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Mulai</label>
                <input type="datetime-local" name="start_date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Selesai (Opsional)</label>
                <input type="datetime-local" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="event">Event</option>
                    <option value="reminder">Reminder</option>
                    <option value="note">Catatan</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeAddEventModal()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddActivityModal(day) {
    const modal = document.getElementById('addActivityModal');
    const dateInput = document.getElementById('activityDate');
    
    if (day) {
        const year = {{ $year }};
        const month = String({{ $month }}).padStart(2, '0');
        const dayStr = String(day).padStart(2, '0');
        dateInput.value = `${year}-${month}-${dayStr}`;
    }
    
    modal.classList.remove('hidden');
}

function closeAddActivityModal() {
    document.getElementById('addActivityModal').classList.add('hidden');
}

function openAddEventModal() {
    document.getElementById('addEventModal').classList.remove('hidden');
}

function closeAddEventModal() {
    document.getElementById('addEventModal').classList.add('hidden');
}

function scrollToDate(day) {
    console.log('Clicked on day:', day);
}

// Close modal when clicking outside
document.getElementById('addActivityModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddActivityModal();
    }
});

document.getElementById('addEventModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddEventModal();
    }
});
</script>
@endsection
