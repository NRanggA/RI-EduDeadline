<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Course;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Screen 3: Detail Tugas
    public function show($id)
    {
        // TODO: Nanti ambil dari database real
        $task = (object) [
            'id' => $id,
            'title' => 'UAS Pemrograman Web',
            'course' => 'Pemrograman Web B',
            'lecturer' => 'Budi Santoso, M.Kom',
            'deadline' => '22 Oktober 2025, 23:59',
            'days_left' => 3,
            'description' => 'Buat website e-commerce dengan Laravel, MySQL, dan Bootstrap. Harus ada fitur login, CRUD produk, dan keranjang belanja.',
            'attachment' => 'soal_uas.pdf',
            'status' => 'pending',
        ];
        
        return view('mahasiswa.detail-tugas', compact('task'));
    }
    
    // Screen 4: Per Mata Kuliah (HMW 4 - Proximity)
    public function perMataKuliah()
    {
        // TODO: Nanti group by course_id dari database
        $courses = [
            (object) [
                'name' => 'Pemrograman Web',
                'icon' => '📘',
                'tasks' => [
                    ['title' => 'UAS Final Project', 'deadline' => '22 Okt'],
                    ['title' => 'Kuis Minggu 8', 'deadline' => '25 Okt'],
                ],
                'progress' => 65,
            ],
            (object) [
                'name' => 'Basis Data',
                'icon' => '🗄️',
                'tasks' => [
                    ['title' => 'Lab Praktikum 5', 'deadline' => '28 Okt'],
                    ['title' => 'Tugas Normalisasi', 'deadline' => '2 Nov'],
                ],
                'progress' => 35,
            ],
            (object) [
                'name' => 'Jaringan Komputer',
                'icon' => '🌐',
                'tasks' => [
                    ['title' => 'Presentasi Kabel', 'deadline' => '30 Okt'],
                ],
                'progress' => 80,
            ],
        ];
        
        return view('mahasiswa.per-mk', compact('courses'));
    }
    
    // Screen 5: Weekly Overview
    public function weekly()
    {
        $days = [
            (object) ['day' => 'Senin (16)', 'tasks' => [
                '📘 Kuis Pemweb (09:00)',
                '🗄️ Diskusi Basdat (14:00)',
            ]],
            (object) ['day' => 'Selasa (17)', 'tasks' => [
                '🌐 Lab Jaringan (13:00)',
            ]],
            (object) ['day' => 'Rabu (18)', 'tasks' => []],
            (object) ['day' => 'Kamis (19)', 'tasks' => [
                '📘 Essay Submit (23:59)',
            ]],
            (object) ['day' => 'Jumat-Minggu (20-22)', 'tasks' => [
                '📘 UAS Pemweb (22, 23:59)',
                '🗄️ Tugas Basdat (21)',
                '🌐 Presentasi (20, 10:00)',
            ], 'heavy' => true],
        ];
        
        return view('mahasiswa.weekly', compact('days'));
    }
    
    // CRUD methods (untuk nanti)
    public function index()
    {
        // List semua tugas
    }
    
    public function create()
    {
        // Form tambah tugas
    }
    
    public function store(Request $request)
    {
        // Simpan tugas baru
    }
    
    public function edit($id)
    {
        // Form edit tugas
    }
    
    public function update(Request $request, $id)
    {
        // Update tugas
    }
    
    public function destroy($id)
    {
        // Hapus tugas
    }
}