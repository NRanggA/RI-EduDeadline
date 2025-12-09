<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Thesis;
use App\Models\ThesisSubmission;
use App\Models\ThesisFeedback;
use App\Models\ThesisSchedule;
use Carbon\Carbon;

class ThesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get mahasiswa user (assume id = 1)
        $mahasiswa = User::where('role', 'mahasiswa')->first();

        // Get dosen users (assume id = 2, 3, etc)
        $dosenList = User::where('role', 'dosen')->take(3)->get();

        if (!$mahasiswa || $dosenList->isEmpty()) {
            // Create test users if not exist
            $mahasiswa = User::create([
                'name' => 'Ahmad Mahasiswa',
                'email' => 'ahmad@example.com',
                'nim' => '210101001',
                'password' => bcrypt('password'),
                'role' => 'mahasiswa',
            ]);

            $dosen1 = User::create([
                'name' => 'Dr. Budi Dosen',
                'email' => 'budi@example.com',
                'password' => bcrypt('password'),
                'role' => 'dosen',
            ]);

            $dosen2 = User::create([
                'name' => 'Prof. Siti Pembimbing',
                'email' => 'siti@example.com',
                'password' => bcrypt('password'),
                'role' => 'dosen',
            ]);

            $dosen3 = User::create([
                'name' => 'Dr. Rudi Penguji',
                'email' => 'rudi@example.com',
                'password' => bcrypt('password'),
                'role' => 'dosen',
            ]);

            $dosenList = collect([$dosen1, $dosen2, $dosen3]);
        }

        // Create thesis
        $thesis = Thesis::create([
            'user_id' => $mahasiswa->id,
            'title' => 'Sistem Rekomendasi E-Commerce Berbasis Machine Learning',
            'description' => 'Penelitian tentang implementasi algoritma machine learning untuk sistem rekomendasi produk di platform e-commerce',
            'advisor_id' => $dosenList[0]->id,
            'co_advisor_id' => $dosenList[1]->id,
            'defense_deadline' => Carbon::now()->addMonths(3),
            'status' => 'in_progress',
        ]);

        // Create submissions
        $submissions = [
            [
                'chapter' => 'Bab 1',
                'title' => 'Pendahuluan',
                'description' => 'Bab pendahuluan berisi latar belakang dan tujuan penelitian',
                'status' => 'approved',
                'version' => 2,
            ],
            [
                'chapter' => 'Bab 2',
                'title' => 'Tinjauan Pustaka',
                'description' => 'Bab tinjauan pustaka berisi studi literatur tentang machine learning dan sistem rekomendasi',
                'status' => 'approved',
                'version' => 2,
            ],
            [
                'chapter' => 'Bab 3',
                'title' => 'Metodologi',
                'description' => 'Bab metodologi berisi penjelasan metode penelitian yang digunakan',
                'status' => 'submitted',
                'version' => 1,
            ],
        ];

        foreach ($submissions as $index => $submission) {
            $thesisSubmission = ThesisSubmission::create([
                'thesis_id' => $thesis->id,
                'user_id' => $mahasiswa->id,
                'chapter' => $submission['chapter'],
                'title' => $submission['title'],
                'description' => $submission['description'],
                'file_path' => 'thesis-submissions/sample-' . strtolower(str_replace(' ', '-', $submission['chapter'])) . '.pdf',
                'status' => $submission['status'],
                'version' => $submission['version'],
            ]);

            // Add feedback for submitted chapters
            if ($submission['status'] === 'submitted') {
                ThesisFeedback::create([
                    'thesis_submission_id' => $thesisSubmission->id,
                    'advisor_id' => $dosenList[0]->id,
                    'feedback' => 'Bagian metodologi perlu diperbaiki. Jelaskan lebih detail tentang dataset yang digunakan dan proses preprocessing.',
                    'type' => 'general',
                    'priority' => 'high',
                    'is_resolved' => false,
                ]);

                ThesisFeedback::create([
                    'thesis_submission_id' => $thesisSubmission->id,
                    'advisor_id' => $dosenList[0]->id,
                    'feedback' => 'Tambahkan diagram alur metodologi agar lebih jelas',
                    'type' => 'specific',
                    'line_number' => 45,
                    'priority' => 'medium',
                    'is_resolved' => false,
                ]);
            }

            // Add feedback for approved chapters
            if ($submission['status'] === 'approved') {
                ThesisFeedback::create([
                    'thesis_submission_id' => $thesisSubmission->id,
                    'advisor_id' => $dosenList[0]->id,
                    'feedback' => 'Sangat bagus! Penjelasan sudah lengkap dan terstruktur dengan baik.',
                    'type' => 'general',
                    'priority' => 'low',
                    'is_resolved' => true,
                ]);
            }
        }

        // Create defense schedule
        ThesisSchedule::create([
            'thesis_id' => $thesis->id,
            'defense_date' => Carbon::now()->addMonths(3)->setHour(9)->setMinute(0),
            'defense_time' => '09:00',
            'location' => 'Ruang Sidang A, Lantai 3',
            'room' => 'A-301',
            'examiner_1_id' => $dosenList[1]->id,
            'examiner_2_id' => $dosenList[2]->id,
            'notes' => 'Silahkan membawa hard copy skripsi sebanyak 3 eksemplar dan flashdisk berisi file skripsi',
            'status' => 'scheduled',
        ]);
    }
}
