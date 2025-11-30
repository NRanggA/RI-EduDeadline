@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="max-w-5xl mx-auto">
	<!-- Header Section -->
	<div class="mb-8">
		<h1 class="text-3xl font-bold text-white mb-2">
			👨‍🏫 Selamat Datang, {{ Auth::user()->name }}!
		</h1>
		<p class="text-white/80">Ini adalah dashboard dosen. Kelola tugas, reminder, dan pantau mahasiswa di sini.</p>
	</div>
	<!-- Konten Dosen -->
	<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
		<div class="card-modern p-6">
			<h2 class="text-xl font-bold mb-2">Reminder Tugas</h2>
			<p class="text-gray-700 mb-4">Kirim pengingat tugas ke mahasiswa dengan mudah.</p>
			<a href="#" class="btn-gradient">Kirim Reminder</a>
		</div>
		<div class="card-modern p-6">
			<h2 class="text-xl font-bold mb-2">Laporan Mahasiswa</h2>
			<p class="text-gray-700 mb-4">Lihat progres dan statistik tugas mahasiswa.</p>
			<a href="#" class="btn-gradient">Lihat Laporan</a>
		</div>
	</div>
</div>
@endsection
