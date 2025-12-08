<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 4; // Muhammad Rizki Pratama (mahasiswa)

        Activity::create([
            'user_id' => $userId,
            'name' => 'Kuliah Pemrograman Web',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 8),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'description' => 'Pembelajaran Pemrograman Web Lanjut',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Kuliah Basis Data',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 10),
            'start_time' => '10:00',
            'end_time' => '12:00',
            'description' => 'Pembelajaran Basis Data dan Query Optimization',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Workshop Git',
            'category' => 'Event Organisasi',
            'date' => Carbon::create(2025, 12, 10),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'description' => 'Workshop tentang penggunaan Git dan GitHub',
        ]);

        // Event dengan bentrok waktu
        Activity::create([
            'user_id' => $userId,
            'name' => 'Kuliah Penweb',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 15),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'description' => 'Praktikum Pemrograman Web',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Seminar Teknologi',
            'category' => 'Event Organisasi',
            'date' => Carbon::create(2025, 12, 15),
            'start_time' => '15:00', // Bentrok dengan Kuliah Penweb (14:00-16:00)
            'end_time' => '17:00',
            'description' => 'Seminar tentang Teknologi Terkini',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Rapat Kelompok',
            'category' => 'Event Organisasi',
            'date' => Carbon::create(2025, 12, 16),
            'start_time' => '19:00',
            'end_time' => '21:00',
            'description' => 'Rapat diskusi kelompok proyek akhir',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Presentasi Project',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 18),
            'start_time' => '13:00',
            'end_time' => '14:30',
            'description' => 'Presentasi hasil project akhir semester',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Kuliah Jaringan Komputer',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 18),
            'start_time' => '15:00', // Tidak bentrok (presentasi berakhir 14:30)
            'end_time' => '17:00',
            'description' => 'Pembelajaran Jaringan Komputer dan Protokol',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Ujian Praktik',
            'category' => 'Kuliah',
            'date' => Carbon::create(2025, 12, 20),
            'start_time' => '08:00',
            'end_time' => '10:00',
            'description' => 'Ujian praktik Pemrograman Web',
        ]);

        Activity::create([
            'user_id' => $userId,
            'name' => 'Meeting Organisasi',
            'category' => 'Event Organisasi',
            'date' => Carbon::create(2025, 12, 22),
            'start_time' => '16:00',
            'end_time' => '17:30',
            'description' => 'Meeting rutin organisasi mahasiswa',
        ]);
    }
}
