<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        // Dummy data kalender
        $calendar = [
            // tanggal => [kuliah, event]
            16 => ['kuliah'],
            17 => ['event'],
            18 => ['kuliah', 'event'],
            19 => ['kuliah'],
            20 => ['event'],
            21 => ['kuliah'],
            22 => ['event'],
            23 => ['event'],
            24 => ['kuliah'],
            25 => ['kuliah', 'event'],
            26 => ['event'],
            27 => ['kuliah'],
            28 => ['event'],
            29 => ['kuliah'],
        ];
        $conflict = false;
        $conflictInfo = null;
        // Contoh: jika ada bentrok di tanggal 25
        if (isset($calendar[25]) && count($calendar[25]) > 1) {
            $conflict = true;
            $conflictInfo = [
                'date' => '25 Okt',
                'items' => [
                    ['type' => 'Kuliah', 'desc' => 'Kuliah Penweb', 'time' => '14:00 - 16:00'],
                    ['type' => 'Event', 'desc' => 'Seminar', 'time' => '13:00 - 17:00'],
                ]
            ];
        }
        return view('mahasiswa.kalender', compact('calendar', 'conflict', 'conflictInfo'));
    }

    public function create()
    {
        return view('mahasiswa.kalender-tambah');
    }

    public function store(Request $request)
    {
        // Simulasi simpan event
        return redirect()->route('mahasiswa.kalender');
    }
}
