@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="flex flex-col items-center justify-start min-h-[80vh] pt-4 pb-8">
    <!-- Header -->
    <div class="w-full max-w-md flex items-center justify-between px-4 mb-6">
        <a href="{{ route('mahasiswa.kalender') }}" class="text-2xl text-white bg-transparent border-0 focus:outline-none hover:opacity-80">
            <span class="material-icons">←</span>
        </a>
        <div class="font-bold text-xl text-white bg-gradient-to-r from-indigo-400 to-purple-500 px-4 py-2 rounded-lg shadow flex-1 text-center">
            Tambah Kegiatan
        </div>
        <div class="w-10"></div> <!-- Spacer for centering -->
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 max-w-sm w-full mx-auto border border-gray-200">
        <form action="{{ route('mahasiswa.tambah-event.store') }}" method="POST" id="tambahKegiatanForm">
            @csrf

            <!-- Nama Kegiatan -->
            <div class="mb-6">
                <label class="block text-gray-800 font-bold mb-2">Nama Kegiatan*</label>
                <input 
                    type="text" 
                    name="nama_kegiatan" 
                    placeholder="Nama Kegiatan"
                    value="{{ old('nama_kegiatan') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400"
                    required>
                @error('nama_kegiatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label class="block text-gray-800 font-bold mb-3">Kategori*</label>
                <div class="space-y-2">
                    <label class="flex items-center cursor-pointer p-3 border-2 border-gray-200 rounded-lg hover:border-purple-500 transition" onclick="this.querySelector('input').checked = true">
                        <input type="radio" name="kategori" value="Kuliah" class="w-5 h-5 text-purple-600 mr-3" {{ old('kategori') === 'Kuliah' ? 'checked' : '' }} required>
                        <span class="text-lg mr-2">📘</span>
                        <span class="text-gray-700 font-semibold">Kuliah</span>
                    </label>
                    <label class="flex items-center cursor-pointer p-3 border-2 border-gray-200 rounded-lg hover:border-purple-500 transition" onclick="this.querySelector('input').checked = true">
                        <input type="radio" name="kategori" value="Event Organisasi" class="w-5 h-5 text-purple-600 mr-3" {{ old('kategori') === 'Event Organisasi' ? 'checked' : '' }}>
                        <span class="text-lg mr-2">🎯</span>
                        <span class="text-gray-700 font-semibold">Event Organisasi</span>
                    </label>
                </div>
                @error('kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal & Waktu -->
            <div class="mb-6">
                <label class="block text-gray-800 font-bold mb-3">Tanggal & Waktu*</label>
                
                <!-- Date -->
                <div class="mb-3">
                    <input 
                        type="date" 
                        name="tanggal"
                        value="{{ old('tanggal', $date ? \Carbon\Carbon::createFromFormat('d', $date)->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                        required>
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jam Mulai</label>
                        <input 
                            type="time" 
                            name="waktu_mulai"
                            value="{{ old('waktu_mulai') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            required>
                        @error('waktu_mulai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Jam Selesai</label>
                        <input 
                            type="time" 
                            name="waktu_selesai"
                            value="{{ old('waktu_selesai') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            required>
                        @error('waktu_selesai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('mahasiswa.kalender') }}"
                    class="flex-1 px-4 py-3 bg-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-400 transition text-center">
                    Batalkan
                </a>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Info Message -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-6 max-w-sm w-full mx-auto">
        <p class="text-blue-700 text-sm">
            <strong>💡 Tips:</strong> Pastikan jadwal Anda tidak bentrok dengan kegiatan lain.
        </p>
    </div>
</div>

<script>
    document.getElementById('tambahKegiatanForm').addEventListener('submit', function(e) {
        const waktuMulai = document.querySelector('input[name="waktu_mulai"]').value;
        const waktuSelesai = document.querySelector('input[name="waktu_selesai"]').value;
        
        if (waktuMulai && waktuSelesai && waktuMulai >= waktuSelesai) {
            e.preventDefault();
            alert('⚠️ Jam selesai harus lebih besar dari jam mulai!');
        }
    });
</script>
@endsection
