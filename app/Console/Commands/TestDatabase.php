<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\Reminder;

class TestDatabase extends Command
{
    protected $signature = 'test:database';
    protected $description = 'Test database integration for dosen dashboard and reminder';

    public function handle()
    {
        $this->line("\n========================================");
        $this->line("  DATABASE INTEGRATION TESTING");
        $this->line("========================================\n");

        // TEST 1: GET DOSEN
        $this->info("TEST 1: GET DOSEN");
        $this->line("-----------------------------------");

        $dosen = User::where('role', 'dosen')->first();
        if ($dosen) {
            $this->line("✅ Dosen found!");
            $this->line("   Name: {$dosen->name}");
            $this->line("   Email: {$dosen->email}");
            $this->line("   NIM: {$dosen->nim}");
            $this->line("   Role: {$dosen->role}\n");
        } else {
            $this->error("❌ No dosen found\n");
            return;
        }

        // TEST 2: GET DOSEN'S COURSES
        $this->info("TEST 2: GET DOSEN'S COURSES");
        $this->line("-----------------------------------");

        $courses = $dosen->courses()->get();
        $this->line("Total courses: {$courses->count()}");
        foreach ($courses as $course) {
            $this->line("  ✓ {$course->name} ({$course->code})");
            $this->line("    - Credits: {$course->credits}");
            $this->line("    - Students: {$course->students()->count()}");
            $this->line("    - Tasks: {$course->tasks()->count()}");
        }
        $this->line("");

        // TEST 3: GET TASKS CREATED BY DOSEN
        $this->info("TEST 3: GET TASKS CREATED BY DOSEN");
        $this->line("-----------------------------------");

        $tasks = Task::where('created_by', $dosen->id)->get();
        $this->line("Total tasks: {$tasks->count()}");
        foreach ($tasks as $task) {
            $completions = $task->completions()->count();
            $enrolled = $task->course->students()->count();
            $this->line("  ✓ {$task->title}");
            $this->line("    - Course: {$task->course->name}");
            $this->line("    - Deadline: {$task->deadline->format('d M Y H:i')}");
            $this->line("    - Priority: {$task->priority}");
            $this->line("    - Status: {$task->status}");
            $this->line("    - Submissions: {$completions}/{$enrolled}");
        }
        $this->line("");

        // TEST 4: GET TASK COMPLETIONS
        $this->info("TEST 4: GET TASK COMPLETIONS");
        $this->line("-----------------------------------");

        if ($tasks->count() > 0) {
            $task = $tasks->first();
            $completions = $task->completions()->with('user')->get();
            $this->line("Task: {$task->title}");
            $this->line("Total submissions: {$completions->count()}");
            foreach ($completions as $completion) {
                $this->line("  ✓ {$completion->user->name}");
                $this->line("    - Status: {$completion->status}");
                $this->line("    - Completed at: {$completion->completed_at?->format('d M Y H:i')}");
            }
        } else {
            $this->line("No tasks found");
        }
        $this->line("");

        // TEST 5: GET MAHASISWA
        $this->info("TEST 5: GET MAHASISWA");
        $this->line("-----------------------------------");

        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $this->line("Total students: {$mahasiswa->count()}");
        foreach ($mahasiswa as $student) {
            $courses = $student->courses()->count();
            $completions = $student->taskCompletions()->count();
            $this->line("  ✓ {$student->name} ({$student->nim})");
            $this->line("    - Courses: {$courses}");
            $this->line("    - Task submissions: {$completions}");
        }
        $this->line("");

        // TEST 6: GET REMINDERS
        $this->info("TEST 6: GET REMINDERS");
        $this->line("-----------------------------------");

        $reminders = $dosen->sentReminders()->with(['course', 'recipients'])->get();
        $this->line("Total reminders sent: {$reminders->count()}");
        foreach ($reminders as $reminder) {
            $this->line("  ✓ {$reminder->title}");
            $this->line("    - Course: {$reminder->course->name}");
            $this->line("    - Type: {$reminder->recipient_type}");
            $this->line("    - Recipients: {$reminder->recipients()->count()}");
            $this->line("    - Sent at: {$reminder->sent_at->format('d M Y H:i')}");
        }
        $this->line("");

        // TEST 7: GET COURSE STUDENTS
        $this->info("TEST 7: GET COURSE STUDENTS");
        $this->line("-----------------------------------");

        // Re-fetch courses for this dosen
        $courses_for_display = Course::where('lecturer_id', $dosen->id)->get();

        if ($courses_for_display->count() > 0) {
            $course = $courses_for_display->first();
            $students = $course->students()->get();
            $this->line("Course: {$course->name}");
            $this->line("Total students: {$students->count()}");
            foreach ($students as $student) {
                $this->line("  ✓ {$student->name} ({$student->nim})");
            }
        } else {
            $this->line("No courses found");
        }
        $this->line("");

        // TEST 8: GET STUDENTS NOT SUBMITTED
        $this->info("TEST 8: GET STUDENTS NOT SUBMITTED");
        $this->line("-----------------------------------");

        if ($tasks->count() > 0) {
            $task = $tasks->first();
            $submitted = TaskCompletion::where('task_id', $task->id)->pluck('user_id');
            $notSubmitted = $task->course->students()
                ->whereNotIn('users.id', $submitted)
                ->get();

            $this->line("Task: {$task->title}");
            $this->line("Students not submitted: {$notSubmitted->count()}");
            foreach ($notSubmitted as $student) {
                $this->line("  ✗ {$student->name} ({$student->nim})");
            }
        } else {
            $this->line("No tasks found");
        }
        $this->line("");

        // TEST 9: GET REMINDER RECIPIENTS
        $this->info("TEST 9: GET REMINDER RECIPIENTS");
        $this->line("-----------------------------------");

        if ($reminders->count() > 0) {
            $reminder = $reminders->first();
            $recipients = $reminder->recipients()->get();
            $this->line("Reminder: {$reminder->title}");
            $this->line("Total recipients: {$recipients->count()}");
            foreach ($recipients as $recipient) {
                $this->line("  ✓ {$recipient->name} ({$recipient->email})");
            }
        } else {
            $this->line("No reminders found");
        }
        $this->line("");

        // TEST 10: STATISTICS
        $this->info("TEST 10: STATISTICS");
        $this->line("-----------------------------------");

        $totalUsers = User::count();
        $totalDosen = User::where('role', 'dosen')->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalCourses = Course::count();
        $totalTasks = Task::count();
        $totalCompletions = TaskCompletion::count();
        $totalReminders = Reminder::count();

        $this->line("Total users: {$totalUsers}");
        $this->line("  - Dosen: {$totalDosen}");
        $this->line("  - Mahasiswa: {$totalMahasiswa}");
        $this->line("");
        $this->line("Courses: {$totalCourses}");
        $this->line("Tasks: {$totalTasks}");
        $this->line("Task completions: {$totalCompletions}");
        $this->line("Reminders: {$totalReminders}");
        $this->line("");

        $this->line("========================================");
        $this->info("  ✅ TESTING COMPLETED");
        $this->line("========================================\n");
    }
}
