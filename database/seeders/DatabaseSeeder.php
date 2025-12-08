<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin Users (Dosen)
        $lecturer1 = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi.santoso@university.edu',
            'nim' => 'D001',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        $lecturer2 = User::create([
            'name' => 'Prof. Siti Nurhaliza',
            'email' => 'siti.nurhaliza@university.edu',
            'nim' => 'D002',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        $lecturer3 = User::create([
            'name' => 'Ir. Ahmad Wijaya',
            'email' => 'ahmad.wijaya@university.edu',
            'nim' => 'D003',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        // 2. Create Students (Mahasiswa)
        $student1 = User::create([
            'name' => 'Muhammad Rizki Pratama',
            'email' => 'rizki.pratama@student.edu',
            'nim' => '2021001',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $student2 = User::create([
            'name' => 'Andi Suryanto',
            'email' => 'andi.suryanto@student.edu',
            'nim' => '2021002',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $student3 = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@student.edu',
            'nim' => '2021003',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $student4 = User::create([
            'name' => 'Bambang Hermawan',
            'email' => 'bambang.hermawan@student.edu',
            'nim' => '2021004',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        $student5 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@student.edu',
            'nim' => '2021005',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // 3. Create Courses (Mata Kuliah)
        $course1 = Course::create([
            'name' => 'Pemrograman Web Lanjut',
            'code' => 'IS301',
            'icon' => '💻',
            'lecturer_id' => $lecturer1->id,
            'description' => 'Mata kuliah lanjutan mengenai pengembangan aplikasi web menggunakan framework Laravel',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course2 = Course::create([
            'name' => 'Basis Data',
            'code' => 'IS202',
            'icon' => '🗄️',
            'lecturer_id' => $lecturer2->id,
            'description' => 'Pengenalan dan pemahaman konsep basis data relasional',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 4,
        ]);

        $course3 = Course::create([
            'name' => 'Algoritma dan Struktur Data',
            'code' => 'IS101',
            'icon' => '📊',
            'lecturer_id' => $lecturer3->id,
            'description' => 'Studi tentang algoritma, kompleksitas waktu, dan struktur data',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        $course4 = Course::create([
            'name' => 'Pemrograman Mobile',
            'code' => 'IS304',
            'icon' => '📱',
            'lecturer_id' => $lecturer1->id,
            'description' => 'Pengembangan aplikasi mobile dengan Flutter dan React Native',
            'semester' => 'Ganjil 2024/2025',
            'credits' => 3,
        ]);

        // 4. Assign Students to Courses
        $course1->students()->attach([
            $student1->id,
            $student2->id,
            $student3->id,
            $student4->id,
            $student5->id
        ]);

        $course2->students()->attach([
            $student1->id,
            $student2->id,
            $student3->id
        ]);

        $course3->students()->attach([
            $student2->id,
            $student4->id,
            $student5->id
        ]);

        $course4->students()->attach([
            $student1->id,
            $student3->id,
            $student4->id
        ]);

        // 5. Create Tasks for Course 1 (Pemrograman Web Lanjut)
        $task1 = Task::create([
            'title' => 'Buat Aplikasi CRUD dengan Laravel',
            'description' => 'Buatlah aplikasi CRUD lengkap menggunakan Laravel dengan fitur login, validasi, dan pagination',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(10),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/laravel-crud-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Gunakan database MySQL dan repository pattern',
        ]);

        $task2 = Task::create([
            'title' => 'Implementasi API REST dengan Authentication',
            'description' => 'Buatlah API REST yang dilengkapi dengan JWT authentication dan role-based access control',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(14),
            'priority' => 'normal',
            'attachment_path' => '/attachments/api-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Dokumentasi API harus lengkap dengan Swagger/OpenAPI',
        ]);

        $task3 = Task::create([
            'title' => 'Deployment Aplikasi ke Cloud',
            'description' => 'Deploy aplikasi Laravel Anda ke AWS atau Heroku dengan setup CI/CD pipeline',
            'course_id' => $course1->id,
            'deadline' => Carbon::now()->addDays(7),
            'priority' => 'urgent',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Sertakan dokumentasi setup dan troubleshooting',
        ]);

        // 6. Create Tasks for Course 2 (Basis Data)
        $task4 = Task::create([
            'title' => 'Desain ER Diagram dan Normalisasi',
            'description' => 'Buatlah ER diagram untuk sistem manajemen inventori dan lakukan normalisasi hingga 3NF',
            'course_id' => $course2->id,
            'deadline' => Carbon::now()->addDays(5),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/database-case-study.pdf',
            'status' => 'pending',
            'created_by' => $lecturer2->id,
            'notes' => 'Gunakan tools seperti Lucidchart atau draw.io',
        ]);

        $task5 = Task::create([
            'title' => 'Query Optimization dan Indexing',
            'description' => 'Optimalkan query-query yang lambat dan terapkan indeksing yang tepat',
            'course_id' => $course2->id,
            'deadline' => Carbon::now()->addDays(12),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer2->id,
            'notes' => 'Sertakan query execution plan dan analisis performance',
        ]);

        // 7. Create Tasks for Course 3 (Algoritma dan Struktur Data)
        $task6 = Task::create([
            'title' => 'Implementasi Binary Search Tree',
            'description' => 'Implementasikan BST dengan operasi insert, delete, dan traversal (inorder, preorder, postorder)',
            'course_id' => $course3->id,
            'deadline' => Carbon::now()->addDays(8),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/bst-requirements.txt',
            'status' => 'pending',
            'created_by' => $lecturer3->id,
            'notes' => 'Analisis kompleksitas waktu untuk setiap operasi',
        ]);

        $task7 = Task::create([
            'title' => 'Sorting Algorithm Comparison',
            'description' => 'Implementasikan berbagai sorting algorithm dan bandingkan performanya',
            'course_id' => $course3->id,
            'deadline' => Carbon::now()->addDays(15),
            'priority' => 'normal',
            'attachment_path' => null,
            'status' => 'pending',
            'created_by' => $lecturer3->id,
            'notes' => 'Implementasikan minimal: Quick Sort, Merge Sort, dan Heap Sort',
        ]);

        // 8. Create Tasks for Course 4 (Pemrograman Mobile)
        $task8 = Task::create([
            'title' => 'Buat Todo App dengan Flutter',
            'description' => 'Buatlah aplikasi Todo dengan fitur add, edit, delete, dan persistent storage',
            'course_id' => $course4->id,
            'deadline' => Carbon::now()->addDays(6),
            'priority' => 'urgent',
            'attachment_path' => '/attachments/flutter-requirements.pdf',
            'status' => 'pending',
            'created_by' => $lecturer1->id,
            'notes' => 'Gunakan Hive atau SQLite untuk local storage',
        ]);

        // 9. Create Task Completions (Pengumpulan Tugas oleh Mahasiswa)

        // Rizki menyelesaikan task1 (Buat Aplikasi CRUD)
        TaskCompletion::create([
            'task_id' => $task1->id,
            'user_id' => $student1->id,
            'submission_file' => '/submissions/rizki-crud-app.zip',
            'completed_at' => Carbon::now()->subDays(2),
            'status' => 'submitted',
            'submission_notes' => 'Aplikasi sudah lengkap dengan semua fitur yang diminta',
        ]);

        // Andi menyelesaikan task1
        TaskCompletion::create([
            'task_id' => $task1->id,
            'user_id' => $student2->id,
            'submission_file' => '/submissions/andi-crud-app.zip',
            'completed_at' => Carbon::now()->subDays(1),
            'status' => 'submitted',
            'submission_notes' => 'Sudah mendapat feedback dari reviewer',
        ]);

        // Rizki menyelesaikan task4 (ER Diagram)
        TaskCompletion::create([
            'task_id' => $task4->id,
            'user_id' => $student1->id,
            'submission_file' => '/submissions/rizki-er-diagram.png',
            'completed_at' => Carbon::now()->subDays(5),
            'status' => 'submitted',
            'submission_notes' => 'ER diagram sudah dinormalisasi sampai 3NF',
        ]);

        // Siti mengerjakan task6 (BST)
        TaskCompletion::create([
            'task_id' => $task6->id,
            'user_id' => $student5->id,
            'submission_file' => '/submissions/siti-bst-implementation.zip',
            'completed_at' => Carbon::now()->subDays(1),
            'status' => 'submitted',
            'submission_notes' => 'Implementasi lengkap dengan unit tests',
        ]);

        // 5. Seed Activities (Kegiatan)
        $this->call(ActivitySeeder::class);
    }
}
