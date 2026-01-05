<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== DOSEN (Lecturers) =====
        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi.santoso@university.edu',
            'nim' => 'D001',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Prof. Siti Nurhaliza',
            'email' => 'siti.nurhaliza@university.edu',
            'nim' => 'D002',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Ir. Ahmad Wijaya',
            'email' => 'ahmad.wijaya@university.edu',
            'nim' => 'D003',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Dr. Eka Prasetyanto',
            'email' => 'eka.prasetyanto@university.edu',
            'nim' => 'D004',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Prof. Retno Widiastuti',
            'email' => 'retno.widiastuti@university.edu',
            'nim' => 'D005',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        // ===== MAHASISWA (Students) =====
        User::create([
            'name' => 'Muhammad Rizki Pratama',
            'email' => 'rizki.pratama@student.edu',
            'nim' => '2021001',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Andi Suryanto',
            'email' => 'andi.suryanto@student.edu',
            'nim' => '2021002',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@student.edu',
            'nim' => '2021003',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Bambang Hermawan',
            'email' => 'bambang.hermawan@student.edu',
            'nim' => '2021004',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@student.edu',
            'nim' => '2021005',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Hendra Kusuma',
            'email' => 'hendra.kusuma@student.edu',
            'nim' => '2021006',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Fitri Handayani',
            'email' => 'fitri.handayani@student.edu',
            'nim' => '2021007',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Roni Hermanto',
            'email' => 'roni.hermanto@student.edu',
            'nim' => '2021008',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Lisa Wijaya',
            'email' => 'lisa.wijaya@student.edu',
            'nim' => '2021009',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Tommy Sutanto',
            'email' => 'tommy.sutanto@student.edu',
            'nim' => '2021010',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);
    }
}
