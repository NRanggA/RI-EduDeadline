<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', 'mahasiswa')->get();

        // Student 1: Muhammad Rizki Pratama
        if ($students->isNotEmpty()) {
            $student1 = $students->first();

            // Aktivitas kuliah
            Activity::create([
                'user_id' => $student1->id,
                'name' => 'Kuliah Pemrograman Web Lanjut',
                'category' => 'Kuliah',
                'date' => Carbon::now()->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'description' => 'Kelas regular Pemrograman Web dengan topik Laravel routing dan middleware',
            ]);

            Activity::create([
                'user_id' => $student1->id,
                'name' => 'Kuliah Basis Data',
                'category' => 'Kuliah',
                'date' => Carbon::now()->addDays(1)->toDateString(),
                'start_time' => '10:30:00',
                'end_time' => '12:30:00',
                'description' => 'Kelas Basis Data dengan topik normalisasi dan query optimization',
            ]);

            Activity::create([
                'user_id' => $student1->id,
                'name' => 'Kuliah Algoritma dan Struktur Data',
                'category' => 'Kuliah',
                'date' => Carbon::now()->addDays(2)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'description' => 'Kelas Algoritma dengan topik Binary Search Tree',
            ]);

            // Event organisasi
            Activity::create([
                'user_id' => $student1->id,
                'name' => 'Rapat Unit Kegiatan Mahasiswa',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(3)->toDateString(),
                'start_time' => '17:00:00',
                'end_time' => '18:30:00',
                'description' => 'Rapat rutin UKM untuk diskusi kegiatan semester ini',
            ]);

            Activity::create([
                'user_id' => $student1->id,
                'name' => 'Workshop Git dan GitHub',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(5)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'description' => 'Workshop gratis tentang version control dan collaboration dengan Git',
            ]);
        }

        // Student 2: Andi Suryanto
        if ($students->count() > 1) {
            $student2 = $students->get(1);

            Activity::create([
                'user_id' => $student2->id,
                'name' => 'Kuliah Pemrograman Mobile',
                'category' => 'Kuliah',
                'date' => Carbon::now()->toDateString(),
                'start_time' => '10:30:00',
                'end_time' => '12:30:00',
                'description' => 'Kelas Pemrograman Mobile dengan topik Flutter widgets',
            ]);

            Activity::create([
                'user_id' => $student2->id,
                'name' => 'Study Group Algoritma',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(4)->toDateString(),
                'start_time' => '15:00:00',
                'end_time' => '17:00:00',
                'description' => 'Study group dengan teman-teman untuk membahas soal algoritma',
            ]);
        }

        // Student 3: Dewi Lestari
        if ($students->count() > 2) {
            $student3 = $students->get(2);

            Activity::create([
                'user_id' => $student3->id,
                'name' => 'Kuliah Jaringan Komputer',
                'category' => 'Kuliah',
                'date' => Carbon::now()->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'description' => 'Kelas Jaringan dengan topik TCP/IP dan routing',
            ]);

            Activity::create([
                'user_id' => $student3->id,
                'name' => 'Kompetisi Programming',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(6)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
                'description' => 'Kompetisi programming tingkat universitas',
            ]);
        }

        // Student 4: Bambang Hermawan
        if ($students->count() > 3) {
            $student4 = $students->get(3);

            Activity::create([
                'user_id' => $student4->id,
                'name' => 'Kuliah Keamanan Sistem',
                'category' => 'Kuliah',
                'date' => Carbon::now()->addDays(1)->toDateString(),
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'description' => 'Kelas Keamanan Sistem dengan topik enkripsi dan authentication',
            ]);

            Activity::create([
                'user_id' => $student4->id,
                'name' => 'Seminar Cloud Computing',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(7)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'description' => 'Seminar tentang teknologi cloud dan aplikasinya',
            ]);
        }

        // Student 5: Siti Aminah
        if ($students->count() > 4) {
            $student5 = $students->get(4);

            Activity::create([
                'user_id' => $student5->id,
                'name' => 'Kuliah Algoritma',
                'category' => 'Kuliah',
                'date' => Carbon::now()->addDays(2)->toDateString(),
                'start_time' => '10:30:00',
                'end_time' => '12:30:00',
                'description' => 'Kelas Algoritma dengan topik sorting dan graph traversal',
            ]);

            Activity::create([
                'user_id' => $student5->id,
                'name' => 'Mentoring Program Juniors',
                'category' => 'Event Organisasi',
                'date' => Carbon::now()->addDays(8)->toDateString(),
                'start_time' => '16:00:00',
                'end_time' => '17:30:00',
                'description' => 'Program mentoring untuk adik-adik tingkat junior',
            ]);
        }

        // Tambahkan aktivitas untuk beberapa hari ke depan untuk siswa 1
        if ($students->isNotEmpty()) {
            $student1 = $students->first();

            for ($i = 0; $i < 14; $i++) {
                $date = Carbon::now()->addDays($i)->toDateString();

                // Jangan tambah jika sudah ada aktivitas di hari itu
                $existingActivities = Activity::where('user_id', $student1->id)
                    ->where('date', $date)
                    ->count();

                if ($existingActivities === 0) {
                    // Random aktivitas
                    $activities = [
                        [
                            'name' => 'Kuliah Pagi',
                            'category' => 'Kuliah',
                            'start_time' => '08:00:00',
                            'end_time' => '10:00:00',
                            'description' => 'Kelas pagi',
                        ],
                        [
                            'name' => 'Kuliah Siang',
                            'category' => 'Kuliah',
                            'start_time' => '13:00:00',
                            'end_time' => '15:00:00',
                            'description' => 'Kelas siang',
                        ],
                        [
                            'name' => 'Lab/Praktikum',
                            'category' => 'Kuliah',
                            'start_time' => '15:00:00',
                            'end_time' => '17:00:00',
                            'description' => 'Praktikum lab komputer',
                        ],
                    ];

                    if (rand(0, 1) === 1 && count($activities) > 0) {
                        $activity = $activities[array_rand($activities)];
                        Activity::create([
                            'user_id' => $student1->id,
                            'name' => $activity['name'],
                            'category' => $activity['category'],
                            'date' => $date,
                            'start_time' => $activity['start_time'],
                            'end_time' => $activity['end_time'],
                            'description' => $activity['description'],
                        ]);
                    }
                }
            }
        }
    }
}
