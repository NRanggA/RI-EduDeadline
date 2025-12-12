<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all lecturer users (role = 'dosen')
        $lecturers = User::where('role', 'dosen')->get();

        if ($lecturers->isEmpty()) {
            // Create sample lecturer if none exists
            $lecturer = User::create([
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@university.edu',
                'password' => bcrypt('password'),
                'role' => 'dosen',
                'student_id' => null,
            ]);
            $lecturers = collect([$lecturer]);
        }

        // Get all courses
        $courses = Course::all();

        if ($courses->isEmpty()) {
            // Create sample courses if none exists
            $lecturers->each(function ($lecturer) use (&$courses) {
                $courses = Course::where('lecturer_id', $lecturer->id)->get();

                if ($courses->isEmpty()) {
                    Course::create([
                        'name' => 'Pemrograman Web',
                        'code' => 'TI101',
                        'icon' => 'icon-web',
                        'lecturer_id' => $lecturer->id,
                        'description' => 'Belajar dasar-dasar pemrograman web dengan PHP dan Laravel',
                        'semester' => 5,
                        'credits' => 3,
                    ]);

                    Course::create([
                        'name' => 'Basis Data',
                        'code' => 'TI102',
                        'icon' => 'icon-database',
                        'lecturer_id' => $lecturer->id,
                        'description' => 'Desain dan implementasi basis data relasional',
                        'semester' => 4,
                        'credits' => 4,
                    ]);

                    Course::create([
                        'name' => 'Sistem Operasi',
                        'code' => 'TI103',
                        'icon' => 'icon-os',
                        'lecturer_id' => $lecturer->id,
                        'description' => 'Konsep dan implementasi sistem operasi modern',
                        'semester' => 3,
                        'credits' => 3,
                    ]);
                }
            });

            $courses = Course::all();
        }

        // Create reports for each lecturer and course combination
        foreach ($lecturers as $lecturer) {
            // Get courses for this lecturer
            $lecturerCourses = $courses->where('lecturer_id', $lecturer->id);

            // Create reports for the last 6 months
            for ($i = 0; $i < 6; $i++) {
                $periodEnd = now()->subMonths($i);
                $periodStart = $periodEnd->copy()->startOfMonth();

                // Create overall report (all courses)
                Report::create([
                    'lecturer_id' => $lecturer->id,
                    'course_id' => null,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'total_tasks' => rand(15, 35),
                    'completed_on_time' => rand(10, 25),
                    'completed_late' => rand(2, 8),
                    'not_submitted' => rand(0, 5),
                    'accuracy_rate' => rand(65, 95),
                    'notes' => 'Laporan keseluruhan bulan ' . $periodStart->format('F Y'),
                ]);

                // Create reports per course
                foreach ($lecturerCourses as $course) {
                    Report::create([
                        'lecturer_id' => $lecturer->id,
                        'course_id' => $course->id,
                        'period_start' => $periodStart,
                        'period_end' => $periodEnd,
                        'total_tasks' => rand(4, 12),
                        'completed_on_time' => rand(3, 10),
                        'completed_late' => rand(0, 4),
                        'not_submitted' => rand(0, 2),
                        'accuracy_rate' => rand(65, 95),
                        'notes' => 'Laporan untuk mata kuliah ' . $course->name,
                    ]);
                }
            }
        }
    }
}
