<?php

namespace Database\Seeders;

use App\Models\Thesis;
use App\Models\ThesisSubmission;
use App\Models\ThesisFeedback;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ThesisDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturer1 = User::where('nim', 'D001')->first(); // Budi Santoso
        $lecturer2 = User::where('nim', 'D002')->first(); // Siti Nurhaliza
        $lecturer3 = User::where('nim', 'D003')->first(); // Ahmad Wijaya
        $lecturer4 = User::where('nim', 'D004')->first(); // Eka Prasetyanto
        $lecturer5 = User::where('nim', 'D005')->first(); // Retno Widiastuti

        $students = User::where('role', 'mahasiswa')->get();

        // Thesis untuk Student 1 (Rizki)
        if ($students->count() > 0) {
            $student1 = $students->get(0);
            $thesis1 = Thesis::create([
                'user_id' => $student1->id,
                'title' => 'Implementasi Machine Learning untuk Prediksi Churn Pelanggan E-Commerce',
                'description' => 'Skripsi ini membahas implementasi algoritma machine learning untuk memprediksi pelanggan yang berpotensi churn dengan tingkat akurasi tinggi',
                'advisor_id' => $lecturer1->id,
                'co_advisor_id' => $lecturer4->id,
                'defense_deadline' => Carbon::now()->addMonths(3),
                'status' => 'in_progress',
            ]);

            // Thesis submissions (BAB I, II, III)
            ThesisSubmission::create([
                'thesis_id' => $thesis1->id,
                'user_id' => $student1->id,
                'chapter' => 'BAB I - Pendahuluan',
                'title' => 'Pendahuluan dan Latar Belakang',
                'file_path' => '/submissions/rizki/bab1-pendahuluan.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis1->id,
                'user_id' => $student1->id,
                'chapter' => 'BAB II - Tinjauan Pustaka',
                'title' => 'Literatur Review dan Dasar Teori',
                'file_path' => '/submissions/rizki/bab2-pustaka.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis1->id,
                'user_id' => $student1->id,
                'chapter' => 'BAB III - Metodologi',
                'title' => 'Metodologi Penelitian',
                'file_path' => '/submissions/rizki/bab3-metodologi.pdf',
                'status' => 'submitted',
                'version' => 1,
            ]);

            // Feedback dari advisor
            $bab1Submission = ThesisSubmission::where('thesis_id', $thesis1->id)->where('chapter', 'BAB I - Pendahuluan')->first();
            $bab2Submission = ThesisSubmission::where('thesis_id', $thesis1->id)->where('chapter', 'BAB II - Tinjauan Pustaka')->first();

            ThesisFeedback::create([
                'thesis_submission_id' => $bab1Submission->id,
                'advisor_id' => $lecturer1->id,
                'feedback' => 'BAB I sudah baik. Tambahkan lebih banyak motivasi penelitian dan kontribusi yang akan diberikan.',
                'type' => 'general',
                'priority' => 'high',
                'is_resolved' => true,
            ]);

            ThesisFeedback::create([
                'thesis_submission_id' => $bab2Submission->id,
                'advisor_id' => $lecturer4->id,
                'feedback' => 'Referensi perlu ditambah, khususnya paper-paper terbaru tentang ML dan customer churn. Perhatikan juga penulisan dan tanda baca.',
                'type' => 'general',
                'priority' => 'high',
                'is_resolved' => false,
            ]);
        }

        // Thesis untuk Student 2 (Andi)
        if ($students->count() > 1) {
            $student2 = $students->get(1);
            $thesis2 = Thesis::create([
                'user_id' => $student2->id,
                'title' => 'Pengembangan Aplikasi IoT untuk Monitoring Kualitas Udara Real-time',
                'description' => 'Penelitian tentang sistem IoT terintegrasi untuk monitoring kualitas udara dengan sensor dan cloud storage',
                'advisor_id' => $lecturer2->id,
                'co_advisor_id' => $lecturer3->id,
                'defense_deadline' => Carbon::now()->addMonths(4),
                'status' => 'planning',
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis2->id,
                'user_id' => $student2->id,
                'chapter' => 'BAB I - Pendahuluan',
                'title' => 'Pengenalan IoT dan Kualitas Udara',
                'file_path' => '/submissions/andi/bab1-pendahuluan.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);
        }

        // Thesis untuk Student 3 (Dewi)
        if ($students->count() > 2) {
            $student3 = $students->get(2);
            $thesis3 = Thesis::create([
                'user_id' => $student3->id,
                'title' => 'Sistem Rekomendasi Konten dengan Content-Based Filtering dan Collaborative Filtering',
                'description' => 'Skripsi tentang implementasi hybrid recommendation system yang menggabungkan content-based dan collaborative filtering',
                'advisor_id' => $lecturer3->id,
                'co_advisor_id' => $lecturer5->id,
                'defense_deadline' => Carbon::now()->addMonths(2),
                'status' => 'submitted',
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis3->id,
                'user_id' => $student3->id,
                'chapter' => 'BAB I - Pendahuluan',
                'title' => 'Pengenalan Sistem Rekomendasi',
                'file_path' => '/submissions/dewi/bab1-pendahuluan.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis3->id,
                'user_id' => $student3->id,
                'chapter' => 'BAB II - Tinjauan Pustaka',
                'title' => 'Content-Based dan Collaborative Filtering',
                'file_path' => '/submissions/dewi/bab2-pustaka.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis3->id,
                'user_id' => $student3->id,
                'chapter' => 'BAB III - Metodologi',
                'title' => 'Metodologi Penelitian',
                'file_path' => '/submissions/dewi/bab3-metodologi.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis3->id,
                'user_id' => $student3->id,
                'chapter' => 'BAB IV - Implementasi',
                'title' => 'Implementasi Hybrid System',
                'file_path' => '/submissions/dewi/bab4-implementasi.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis3->id,
                'user_id' => $student3->id,
                'chapter' => 'BAB V - Pengujian dan Evaluasi',
                'title' => 'Pengujian dan Evaluasi Sistem',
                'file_path' => '/submissions/dewi/bab5-pengujian.pdf',
                'status' => 'submitted',
                'version' => 1,
            ]);

            $bab4Submission = ThesisSubmission::where('thesis_id', $thesis3->id)->where('chapter', 'BAB IV - Implementasi')->first();

            ThesisFeedback::create([
                'thesis_submission_id' => $bab4Submission->id,
                'advisor_id' => $lecturer3->id,
                'feedback' => 'Implementasi sudah bagus. Pastikan dokumentasi code lengkap dan sertakan diagram arsitektur yang lebih detail.',
                'type' => 'general',
                'priority' => 'medium',
                'is_resolved' => true,
            ]);
        }

        // Thesis untuk Student 4 (Bambang)
        if ($students->count() > 3) {
            $student4 = $students->get(3);
            $thesis4 = Thesis::create([
                'user_id' => $student4->id,
                'title' => 'Optimasi Database Query menggunakan Query Caching dan Indexing Strategy',
                'description' => 'Penelitian tentang teknik optimasi query database untuk meningkatkan performance aplikasi',
                'advisor_id' => $lecturer4->id,
                'co_advisor_id' => $lecturer2->id,
                'defense_deadline' => Carbon::now()->addMonths(5),
                'status' => 'in_progress',
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis4->id,
                'user_id' => $student4->id,
                'chapter' => 'BAB I - Pendahuluan',
                'title' => 'Pengenalan Database Optimization',
                'file_path' => '/submissions/bambang/bab1-pendahuluan.pdf',
                'status' => 'submitted',
                'version' => 1,
            ]);
        }

        // Thesis untuk Student 5 (Siti)
        if ($students->count() > 4) {
            $student5 = $students->get(4);
            $thesis5 = Thesis::create([
                'user_id' => $student5->id,
                'title' => 'Analisis Keamanan Web Application terhadap OWASP Top 10 Vulnerabilities',
                'description' => 'Skripsi tentang identifikasi dan mitigasi vulnerabilities pada web application berdasarkan OWASP Top 10',
                'advisor_id' => $lecturer5->id,
                'co_advisor_id' => $lecturer1->id,
                'defense_deadline' => Carbon::now()->addMonths(3),
                'status' => 'defended',
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB I - Pendahuluan',
                'title' => 'Keamanan Web dan OWASP Top 10',
                'file_path' => '/submissions/siti/bab1-pendahuluan.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB II - Tinjauan Pustaka',
                'title' => 'Review Literatur Keamanan Web',
                'file_path' => '/submissions/siti/bab2-pustaka.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB III - Metodologi',
                'title' => 'Metodologi Security Testing',
                'file_path' => '/submissions/siti/bab3-metodologi.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB IV - Implementasi',
                'title' => 'Implementasi Security Testing Tools',
                'file_path' => '/submissions/siti/bab4-implementasi.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB V - Pengujian dan Evaluasi',
                'title' => 'Hasil Testing dan Findings',
                'file_path' => '/submissions/siti/bab5-pengujian.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            ThesisSubmission::create([
                'thesis_id' => $thesis5->id,
                'user_id' => $student5->id,
                'chapter' => 'BAB VI - Kesimpulan dan Saran',
                'title' => 'Kesimpulan dan Rekomendasi',
                'file_path' => '/submissions/siti/bab6-kesimpulan.pdf',
                'status' => 'approved',
                'version' => 1,
            ]);

            $bab2SubmissionSiti = ThesisSubmission::where('thesis_id', $thesis5->id)->where('chapter', 'BAB II - Tinjauan Pustaka')->first();
            $bab4SubmissionSiti = ThesisSubmission::where('thesis_id', $thesis5->id)->where('chapter', 'BAB IV - Implementasi')->first();

            ThesisFeedback::create([
                'thesis_submission_id' => $bab2SubmissionSiti->id,
                'advisor_id' => $lecturer5->id,
                'feedback' => 'Literatur review sudah lengkap dan komprehensif. Tinjauan OWASP vulnerabilities sangat detail.',
                'type' => 'general',
                'priority' => 'low',
                'is_resolved' => true,
            ]);

            ThesisFeedback::create([
                'thesis_submission_id' => $bab4SubmissionSiti->id,
                'advisor_id' => $lecturer1->id,
                'feedback' => 'Implementasi security testing sangat baik. Hasil findings dan remediation steps sangat actionable.',
                'type' => 'general',
                'priority' => 'low',
                'is_resolved' => true,
            ]);
        }
    }
}
