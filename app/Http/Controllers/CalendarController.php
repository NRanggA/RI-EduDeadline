<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        // Dummy data kalender dengan detail kegiatan
        $activities = [
            // tanggal => [['type' => 'kuliah'|'event', 'name' => '', 'time' => '', 'startTime' => '14:00', 'endTime' => '16:00'], ...]
            16 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Pemrograman Web', 'time' => '09:00 - 11:00', 'startTime' => '09:00', 'endTime' => '11:00']
            ],
            17 => [
                ['type' => 'event', 'name' => 'Seminar AI', 'time' => '13:00 - 15:00', 'startTime' => '13:00', 'endTime' => '15:00']
            ],
            18 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Basis Data', 'time' => '10:00 - 12:00', 'startTime' => '10:00', 'endTime' => '12:00'],
                ['type' => 'event', 'name' => 'Workshop Git', 'time' => '14:00 - 16:00', 'startTime' => '14:00', 'endTime' => '16:00']
            ],
            19 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Jaringan', 'time' => '13:00 - 15:00', 'startTime' => '13:00', 'endTime' => '15:00']
            ],
            20 => [
                ['type' => 'event', 'name' => 'Rapat Organisasi', 'time' => '16:00 - 17:30', 'startTime' => '16:00', 'endTime' => '17:30']
            ],
            21 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Pemrograman Web', 'time' => '09:00 - 11:00', 'startTime' => '09:00', 'endTime' => '11:00']
            ],
            22 => [
                ['type' => 'event', 'name' => 'Ujian Praktik', 'time' => '08:00 - 10:00', 'startTime' => '08:00', 'endTime' => '10:00']
            ],
            23 => [
                ['type' => 'event', 'name' => 'Diskusi Kelompok', 'time' => '19:00 - 21:00', 'startTime' => '19:00', 'endTime' => '21:00']
            ],
            24 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Algoritma', 'time' => '10:00 - 12:00', 'startTime' => '10:00', 'endTime' => '12:00']
            ],
            25 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Penweb', 'time' => '14:00 - 16:00', 'startTime' => '14:00', 'endTime' => '16:00'],
                ['type' => 'event', 'name' => 'Seminar', 'time' => '13:00 - 17:00', 'startTime' => '13:00', 'endTime' => '17:00']
            ],
            26 => [
                ['type' => 'event', 'name' => 'Meeting', 'time' => '15:00 - 16:00', 'startTime' => '15:00', 'endTime' => '16:00']
            ],
            27 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Basis Data', 'time' => '10:00 - 12:00', 'startTime' => '10:00', 'endTime' => '12:00']
            ],
            28 => [
                ['type' => 'event', 'name' => 'Presentasi', 'time' => '13:00 - 14:30', 'startTime' => '13:00', 'endTime' => '14:30']
            ],
            29 => [
                ['type' => 'kuliah', 'name' => 'Kuliah Jaringan', 'time' => '13:00 - 15:00', 'startTime' => '13:00', 'endTime' => '15:00']
            ],
        ];

        // Buat data kalender untuk menampilkan dots
        $calendar = [];
        foreach ($activities as $date => $acts) {
            $types = array_map(fn($act) => $act['type'], $acts);
            $calendar[$date] = $types;
        }

        $conflict = false;
        $conflictInfo = null;
        // Contoh: jika ada bentrok di tanggal 25
        if (isset($activities[25]) && count($activities[25]) > 1) {
            if ($this->hasTimeConflict($activities[25])) {
                $conflict = true;
                $conflictInfo = [
                    'date' => '25 Okt',
                    'items' => $activities[25]
                ];
            }
        }

        return view('mahasiswa.kalender', compact('calendar', 'conflict', 'conflictInfo', 'activities'));
    }

    public function create(Request $request)
    {
        $date = $request->query('date');
        $month = $request->query('month', 10); // Default Oktober
        $year = $request->query('year', 2025);

        return view('mahasiswa.kalender-tambah', compact('date', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kategori' => 'required|in:Kuliah,Event Organisasi',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        // TODO: Simpan ke database (nanti integrasi dengan Model)
        // Untuk sekarang, redirect kembali ke kalender

        return redirect()->route('mahasiswa.kalender');
    }

    /**
     * Deteksi apakah ada bentrok waktu antara kegiatan
     * @param array $activities
     * @return bool
     */
    private function hasTimeConflict($activities)
    {
        if (count($activities) < 2) {
            return false;
        }

        for ($i = 0; $i < count($activities) - 1; $i++) {
            for ($j = $i + 1; $j < count($activities); $j++) {
                $act1 = $activities[$i];
                $act2 = $activities[$j];

                // Parse waktu
                $start1 = strtotime($act1['startTime']);
                $end1 = strtotime($act1['endTime']);
                $start2 = strtotime($act2['startTime']);
                $end2 = strtotime($act2['endTime']);

                // Cek overlap
                if ($start1 < $end2 && $start2 < $end1) {
                    return true;
                }
            }
        }

        return false;
    }
}
