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
        <button onclick="openAddActivityModal(null)" class="text-2xl text-white bg-transparent border-0 focus:outline-none hover:opacity-80">
            <span class="material-icons">add</span>
        </button>
    </div>
    
    <!-- Kalender Card -->
    <div class="bg-white rounded-xl shadow-lg p-4 max-w-xs w-full mx-auto mb-6 border border-gray-300" style="min-width:480px;">
        <div class="text-center font-bold text-lg mb-2">Kalender Oktober 2025</div>
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
                            <button 
                                class="w-full relative flex flex-col items-center p-2 rounded hover:bg-purple-100 transition cursor-pointer focus:outline-none active:bg-purple-200"
                                onclick="openAddActivityModal({{ $date }})"
                                title="Klik untuk tambah kegiatan">
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
                            </button>
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

    <!-- Conflict Alert Modal -->
    @if($conflict)
    <div id="conflictModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full animate-fadeIn">
            <!-- Header -->
            <div class="bg-red-500 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center gap-3 justify-center">
                    <span class="text-3xl">⚠️</span>
                    <span class="font-bold text-lg">PERINGATAN BENTROK</span>
                </div>
            </div>
            
            <!-- Content -->
            <div class="px-6 py-6">
                <div class="text-center mb-4">
                    <p class="text-gray-700 font-semibold mb-2">Tanggal: <span class="text-red-600 text-lg">{{ $conflictInfo['date'] }}</span></p>
                </div>
                
                <div class="space-y-3 mb-6 max-h-80 overflow-y-auto">
                    @foreach($conflictInfo['items'] as $item)
                    <div class="border-l-4 @if($item['type'] === 'kuliah') border-purple-700 bg-purple-50 @else border-yellow-500 bg-yellow-50 @endif p-3 rounded">
                        <p class="font-semibold text-sm @if($item['type'] === 'kuliah') text-purple-700 @else text-yellow-700 @endif">
                            @if($item['type'] === 'kuliah') 📘 @else 🎯 @endif
                            {{ ucfirst($item['type']) }}
                        </p>
                        <p class="text-sm text-gray-700 mt-1">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-600 mt-1">⏰ {{ $item['time'] }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded mb-6">
                    <p class="text-red-700 text-sm font-semibold">⚠️ Ada kegiatan yang bentrok waktu!</p>
                    <p class="text-red-600 text-xs mt-1">Silakan revisi jadwal Anda agar tidak ada duplikasi waktu.</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="flex gap-3 px-6 py-4 bg-gray-50 rounded-b-xl">
                <button 
                    onclick="closeConflictModal()"
                    class="flex-1 px-4 py-2 bg-gray-400 text-white font-semibold rounded hover:bg-gray-500 transition">
                    Ubah
                </button>
                <button 
                    onclick="closeConflictModal()"
                    class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Add Activity Modal -->
    <div id="addActivityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full animate-slideUp">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white px-6 py-4 rounded-t-xl flex items-center gap-3">
                <button onclick="closeAddActivityModal()" class="text-2xl hover:opacity-80">←</button>
                <span class="font-bold text-lg flex-1 text-center">Tambah Kegiatan</span>
            </div>
            
            <!-- Form -->
            <form id="addActivityForm" action="{{ route('mahasiswa.tambah-event.store') }}" method="POST" class="px-6 py-6 max-h-96 overflow-y-auto">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Nama Kegiatan*</label>
                    <input type="text" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Kategori*</label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer p-2 hover:bg-purple-50 rounded transition">
                            <input type="radio" name="kategori" value="Kuliah" class="mr-2 w-4 h-4" checked>
                            <span class="text-lg mr-2">📘</span>
                            <span class="text-gray-700 text-sm">Kuliah</span>
                        </label>
                        <label class="flex items-center cursor-pointer p-2 hover:bg-purple-50 rounded transition">
                            <input type="radio" name="kategori" value="Event Organisasi" class="mr-2 w-4 h-4">
                            <span class="text-lg mr-2">🎯</span>
                            <span class="text-gray-700 text-sm">Event Organisasi</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Tanggal & Waktu*</label>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" id="selectedDate" placeholder="Tanggal" 
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                            readonly>
                        <input type="time" name="waktu_mulai" placeholder="Jam Mulai" 
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                            required>
                    </div>
                    <input type="time" name="waktu_selesai" placeholder="Jam Selesai" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm"
                        required>
                    <input type="hidden" name="tanggal" id="hiddenDate">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeAddActivityModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition text-sm">
                        Batalkan
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }

    .animate-slideUp {
        animation: slideUp 0.3s ease-in-out;
    }
</style>

<script>
    const currentMonth = 10;
    const currentYear = 2025;
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    function openAddActivityModal(date) {
        const modal = document.getElementById('addActivityModal');
        const dateInput = document.getElementById('selectedDate');
        const hiddenDate = document.getElementById('hiddenDate');
        
        if (date) {
            // Format tanggal ketika klik di kalender
            const dateStr = `${date} ${monthNames[currentMonth - 1]}`;
            const fullDate = new Date(`${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(date).padStart(2, '0')}`);
            
            dateInput.value = dateStr;
            hiddenDate.value = fullDate.toISOString().split('T')[0];
        } else {
            // Reset untuk add activity dari button
            dateInput.value = '';
            hiddenDate.value = '';
        }
        
        modal.classList.remove('hidden');
        document.getElementById('addActivityForm').reset();
        if (date) {
            document.getElementById('selectedDate').value = `${date} ${monthNames[currentMonth - 1]}`;
        }
    }
    
    function closeAddActivityModal() {
        const modal = document.getElementById('addActivityModal');
        modal.classList.add('hidden');
        document.getElementById('addActivityForm').reset();
    }
    
    function closeConflictModal() {
        const modal = document.getElementById('conflictModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Validasi form
    document.getElementById('addActivityForm').addEventListener('submit', function(e) {
        const waktuMulai = document.querySelector('input[name="waktu_mulai"]').value;
        const waktuSelesai = document.querySelector('input[name="waktu_selesai"]').value;
        const tanggal = document.getElementById('hiddenDate').value;
        
        if (!tanggal) {
            e.preventDefault();
            alert('⚠️ Silakan pilih tanggal terlebih dahulu!');
            return;
        }
        
        if (waktuMulai && waktuSelesai && waktuMulai >= waktuSelesai) {
            e.preventDefault();
            alert('⚠️ Jam selesai harus lebih besar dari jam mulai!');
        }
    });

    // Close modal ketika click di luar
    document.getElementById('addActivityModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddActivityModal();
        }
    });
</script>
@endsection
