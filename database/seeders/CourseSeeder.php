<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get lecturers
        $lecturer1 = User::where('nim', 'D001')->first(); // Budi Santoso
        $lecturer2 = User::where('nim', 'D002')->first(); // Siti Nurhaliza
        $lecturer3 = User::where('nim', 'D003')->first(); // Ahmad Wijaya
        $lecturer4 = User::where('nim', 'D004')->first(); // Eka Prasetyanto
        $lecturer5 = User::where('nim', 'D005')->first(); // Retno Widiastuti

        // Create courses
        $course1 = Course::create([
            'name' => 'Pemrograman Web Lanjut',
            'code' => 'IS301',
            'icon' => '💻',
            'lecturer_id' => $lecturer1->id,
            'description' => 'Mata kuliah lanjutan mengenai pengembangan aplikasi web menggunakan framework Laravel dan teknologi terkini',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course2 = Course::create([
            'name' => 'Basis Data',
            'code' => 'IS202',
            'icon' => '🗄️',
            'lecturer_id' => $lecturer2->id,
            'description' => 'Pengenalan dan pemahaman konsep basis data relasional, SQL, dan normalisasi database',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 4,
        ]);

        $course3 = Course::create([
            'name' => 'Algoritma dan Struktur Data',
            'code' => 'IS101',
            'icon' => '📊',
            'lecturer_id' => $lecturer3->id,
            'description' => 'Studi tentang algoritma, kompleksitas waktu, dan struktur data seperti array, linked list, tree, dan graph',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course4 = Course::create([
            'name' => 'Pemrograman Mobile',
            'code' => 'IS304',
            'icon' => '📱',
            'lecturer_id' => $lecturer1->id,
            'description' => 'Pengembangan aplikasi mobile dengan Flutter dan React Native untuk platform iOS dan Android',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course5 = Course::create([
            'name' => 'Jaringan Komputer',
            'code' => 'IS205',
            'icon' => '🌐',
            'lecturer_id' => $lecturer4->id,
            'description' => 'Konsep dasar jaringan komputer, protokol TCP/IP, dan arsitektur jaringan',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course6 = Course::create([
            'name' => 'Keamanan Sistem Informasi',
            'code' => 'IS401',
            'icon' => '🔐',
            'lecturer_id' => $lecturer5->id,
            'description' => 'Enkripsi, autentikasi, otorisasi, dan praktik keamanan sistem informasi',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        // Assign students to courses
        $students = User::where('role', 'mahasiswa')->get();

        // Distribute students across courses
        $course1->students()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]); // Semua mahasiswa
        $course2->students()->sync([1, 2, 3, 6, 7, 8]); // 6 mahasiswa
        $course3->students()->sync([2, 4, 5, 8, 9, 10]); // 6 mahasiswa
        $course4->students()->sync([1, 3, 7, 9]); // 4 mahasiswa
        $course5->students()->sync([1, 2, 4, 5, 6, 10]); // 6 mahasiswa
        $course6->students()->sync([3, 6, 7, 8, 9]); // 5 mahasiswa
    }
}
