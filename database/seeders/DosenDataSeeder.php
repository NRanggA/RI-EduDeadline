<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\Reminder;
use Carbon\Carbon;

class DosenDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a lecturer (dosen)
        $dosen = User::firstOrCreate(
            ['nim' => 'D001'],
            [
                'name' => 'Dr. Ahmad Wijaya',
                'email' => 'dosen@example.com',
                'password' => bcrypt('password123'),
                'role' => 'dosen',
            ]
        );

        // Create multiple students (mahasiswa)
        $students = [];
        for ($i = 1; $i <= 5; $i++) {
            $students[] = User::firstOrCreate(
                ['nim' => "M00{$i}"],
                [
                    'name' => "Mahasiswa {$i}",
                    'email' => "mahasiswa{$i}@example.com",
                    'password' => bcrypt('password123'),
                    'role' => 'mahasiswa',
                ]
            );
        }

        // Create courses taught by the lecturer
        $course1 = Course::firstOrCreate(
            ['code' => 'IS101'],
            [
                'name' => 'Database Management System',
                'code' => 'IS101',
                'icon' => '🗄️',
                'lecturer_id' => $dosen->id,
                'description' => 'Pembelajaran dasar sistem manajemen basis data',
                'semester' => 'Ganjil 2024',
                'credits' => 3,
            ]
        );

        $course2 = Course::firstOrCreate(
            ['code' => 'IS102'],
            [
                'name' => 'Web Application Development',
                'code' => 'IS102',
                'icon' => '🌐',
                'lecturer_id' => $dosen->id,
                'description' => 'Pembelajaran pengembangan aplikasi web modern',
                'semester' => 'Ganjil 2024',
                'credits' => 4,
            ]
        );

        // Attach students to courses
        foreach ($students as $student) {
            $course1->students()->syncWithoutDetaching($student->id);
            $course2->students()->syncWithoutDetaching($student->id);
        }

        // Create tasks for course 1
        $task1 = Task::firstOrCreate(
            ['title' => 'SQL Query Assignment'],
            [
                'title' => 'SQL Query Assignment',
                'description' => 'Tugas membuat SQL query untuk relasi table multiple',
                'course_id' => $course1->id,
                'deadline' => Carbon::now()->addDays(5),
                'priority' => 'urgent',
                'status' => 'pending',
                'created_by' => $dosen->id,
            ]
        );

        $task2 = Task::firstOrCreate(
            ['title' => 'Database Design Project'],
            [
                'title' => 'Database Design Project',
                'description' => 'Merancang database untuk sistem manajemen perpustakaan',
                'course_id' => $course1->id,
                'deadline' => Carbon::now()->addDays(14),
                'priority' => 'normal',
                'status' => 'pending',
                'created_by' => $dosen->id,
            ]
        );

        // Create tasks for course 2
        $task3 = Task::firstOrCreate(
            ['title' => 'Build Todo App'],
            [
                'title' => 'Build Todo App',
                'description' => 'Membuat aplikasi Todo dengan HTML, CSS, dan JavaScript',
                'course_id' => $course2->id,
                'deadline' => Carbon::now()->addDays(3),
                'priority' => 'urgent',
                'status' => 'pending',
                'created_by' => $dosen->id,
            ]
        );

        $task4 = Task::firstOrCreate(
            ['title' => 'E-commerce Website'],
            [
                'title' => 'E-commerce Website',
                'description' => 'Membuat website e-commerce dengan fitur lengkap',
                'course_id' => $course2->id,
                'deadline' => Carbon::now()->subDays(2),
                'priority' => 'urgent',
                'status' => 'overdue',
                'created_by' => $dosen->id,
            ]
        );

        // Create task completions (submissions)
        // Some students submitted, some didn't
        TaskCompletion::firstOrCreate(
            ['task_id' => $task1->id, 'user_id' => $students[0]->id],
            [
                'task_id' => $task1->id,
                'user_id' => $students[0]->id,
                'status' => 'approved',
                'completed_at' => Carbon::now()->subDays(2),
                'submission_notes' => 'Query sudah benar dan efisien',
            ]
        );

        TaskCompletion::firstOrCreate(
            ['task_id' => $task1->id, 'user_id' => $students[1]->id],
            [
                'task_id' => $task1->id,
                'user_id' => $students[1]->id,
                'status' => 'submitted',
                'completed_at' => Carbon::now()->subHours(12),
                'submission_notes' => 'Menunggu review dari dosen',
            ]
        );

        TaskCompletion::firstOrCreate(
            ['task_id' => $task3->id, 'user_id' => $students[0]->id],
            [
                'task_id' => $task3->id,
                'user_id' => $students[0]->id,
                'status' => 'approved',
                'completed_at' => Carbon::now()->subDay(),
            ]
        );

        TaskCompletion::firstOrCreate(
            ['task_id' => $task4->id, 'user_id' => $students[2]->id],
            [
                'task_id' => $task4->id,
                'user_id' => $students[2]->id,
                'status' => 'submitted',
                'completed_at' => Carbon::now()->subHours(5),
            ]
        );

        // Create sample reminders
        $reminder1 = Reminder::firstOrCreate(
            ['title' => 'Pengingat SQL Query Assignment'],
            [
                'course_id' => $course1->id,
                'lecturer_id' => $dosen->id,
                'title' => 'Pengingat SQL Query Assignment',
                'message' => 'Halo teman-teman, jangan lupa kumpulkan tugas SQL Query Assignment sebelum deadline ya!',
                'recipient_type' => 'not_submitted',
                'scheduled_at' => Carbon::now(),
                'sent_at' => Carbon::now()->subDays(1),
                'is_sent' => true,
            ]
        );

        // Attach recipients to reminder
        $reminder1->recipients()->sync([
            $students[2]->id,
            $students[3]->id,
            $students[4]->id,
        ]);

        $reminder2 = Reminder::firstOrCreate(
            ['title' => 'Pengingat E-commerce Website (OVERDUE)'],
            [
                'course_id' => $course2->id,
                'lecturer_id' => $dosen->id,
                'title' => 'Pengingat E-commerce Website (OVERDUE)',
                'message' => 'Tugas E-commerce Website sudah melewati deadline. Segera kumpulkan agar tidak ada pengurangan nilai!',
                'recipient_type' => 'overdue',
                'scheduled_at' => Carbon::now(),
                'sent_at' => Carbon::now(),
                'is_sent' => true,
            ]
        );

        // Attach recipients to reminder
        $reminder2->recipients()->sync([
            $students[0]->id,
            $students[1]->id,
            $students[3]->id,
            $students[4]->id,
        ]);

        $this->command->info('Dosen data seeded successfully!');
        $this->command->info("Dosen email: dosen@example.com | Password: password123");
        $this->command->info("Sample student email: mahasiswa1@example.com | Password: password123");
    }
}
