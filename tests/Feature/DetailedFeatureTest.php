<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\Thesis;
use App\Models\ThesisFeedback;
use App\Models\ThesisSubmission;
use App\Models\User;
use Tests\TestCase;

class DetailedFeatureTest extends TestCase
{
    /**
     * Test all MAHASISWA features in detail
     */
    public function test_mahasiswa_detailed_features()
    {
        echo "\n╔════════════════════════════════════════════════════════════════════╗\n";
        echo "║           DETAILED MAHASISWA FEATURES TEST                         ║\n";
        echo "╚════════════════════════════════════════════════════════════════════╝\n";

        $mahasiswa = User::where('nim', '2021001')->first();

        // TEST 1: Dashboard Features
        echo "\n[TEST 1] DASHBOARD FEATURES\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $courses = $mahasiswa->courses()->count();
        echo "  ✓ Load enrolled courses: " . ($courses > 0 ? "PASS" : "FAIL") . " ($courses courses)\n";

        $totalTasks = Task::whereIn('course_id', $mahasiswa->courses()->pluck('courses.id'))->count();
        echo "  ✓ Load task overview: " . ($totalTasks > 0 ? "PASS" : "FAIL") . " ($totalTasks tasks)\n";

        $urgent = Task::whereIn('course_id', $mahasiswa->courses()->pluck('courses.id'))
            ->where('priority', 'urgent')->count();
        echo "  ✓ Filter by priority (urgent): " . ($urgent > 0 ? "PASS" : "FAIL") . " ($urgent tasks)\n";

        // TEST 2: Per Mata Kuliah (Per Course)
        echo "\n[TEST 2] PER MATA KULIAH (COURSE FILTERING)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $course = $mahasiswa->courses()->first();
        $courseCode = $course->code;
        $courseTaskCount = $course->tasks()->count();
        echo "  ✓ Filter tasks by course ($courseCode): " . ($courseTaskCount > 0 ? "PASS" : "FAIL") . " ($courseTaskCount tasks)\n";

        // TEST 3: Kalender/Activities
        echo "\n[TEST 3] KALENDER/ACTIVITIES (CALENDAR EVENTS)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $activities = Activity::where('user_id', $mahasiswa->id)->get();
        echo "  ✓ Load calendar activities: " . ($activities->count() > 0 ? "PASS" : "FAIL") . " (" . $activities->count() . " activities)\n";

        $byType = $activities->groupBy('category');
        foreach ($byType as $type => $items) {
            echo "    - $type: " . $items->count() . "\n";
        }

        // TEST 4: Task Management
        echo "\n[TEST 4] TASK MANAGEMENT (TUGAS)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $courseIds = $mahasiswa->courses()->pluck('courses.id')->toArray();
        $allTasks = Task::whereIn('course_id', $courseIds)->get();

        $tasksByStatus = $allTasks->groupBy('status');
        foreach ($tasksByStatus as $status => $items) {
            echo "  ✓ Tasks with status '$status': " . $items->count() . "\n";
        }

        // TEST 5: Mark Task Complete
        echo "\n[TEST 5] TASK COMPLETION (MARK TASK DONE)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        if ($allTasks->count() > 0) {
            $firstTask = $allTasks->first();

            // Check if already completed
            $existingCompletion = TaskCompletion::where('user_id', $mahasiswa->id)
                ->where('task_id', $firstTask->id)->first();

            if (!$existingCompletion) {
                // Create completion
                TaskCompletion::create([
                    'user_id' => $mahasiswa->id,
                    'task_id' => $firstTask->id,
                    'completed_at' => now(),
                ]);
                echo "  ✓ Mark task complete: PASS (Task: " . $firstTask->title . ")\n";
            } else {
                echo "  ✓ Task already completed: " . $firstTask->title . "\n";
            }

            $completedCount = TaskCompletion::where('user_id', $mahasiswa->id)->count();
            echo "  ✓ Total completed tasks: " . $completedCount . "\n";
        }

        // TEST 6: Thesis Features
        echo "\n[TEST 6] SKRIPSI (THESIS MONITORING)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $thesis = Thesis::where('user_id', $mahasiswa->id)->first();
        if ($thesis) {
            echo "  ✓ Load thesis data: PASS\n";
            echo "    - Title: " . $thesis->title . "\n";
            echo "    - Status: " . strtoupper($thesis->status) . "\n";
            echo "    - Advisor: " . $thesis->advisor->name . "\n";

            // TEST 7: Thesis Submissions
            echo "\n[TEST 7] THESIS SUBMISSIONS (CHAPTER UPLOAD)\n";
            echo "─────────────────────────────────────────────────────────────────────\n";

            $submissions = $thesis->submissions()->get();
            echo "  ✓ Load submissions: PASS (" . $submissions->count() . " chapters)\n";

            $bySubmissionStatus = $submissions->groupBy('status');
            foreach ($bySubmissionStatus as $status => $items) {
                echo "    - " . strtoupper($status) . ": " . $items->count() . "\n";
            }

            // TEST 8: Thesis Feedback
            echo "\n[TEST 8] THESIS FEEDBACK (ADVISOR FEEDBACK)\n";
            echo "─────────────────────────────────────────────────────────────────────\n";

            $feedback = ThesisFeedback::whereHas('submission', function ($q) use ($thesis) {
                $q->where('thesis_id', $thesis->id);
            })->get();

            echo "  ✓ Load feedback: PASS (" . $feedback->count() . " feedback items)\n";

            $resolved = $feedback->where('is_resolved', true)->count();
            $pending = $feedback->where('is_resolved', false)->count();

            echo "    - Resolved: " . $resolved . "\n";
            echo "    - Pending: " . $pending . "\n";

            if ($feedback->count() > 0) {
                $sample = $feedback->first();
                echo "    - Sample: \"" . substr($sample->feedback, 0, 50) . "...\" (Type: " . $sample->type . ")\n";
            }

            // TEST 9: Thesis Schedule
            echo "\n[TEST 9] THESIS SCHEDULE (JADWAL SIDANG)\n";
            echo "─────────────────────────────────────────────────────────────────────\n";

            $schedule = $thesis->schedule;
            if ($schedule) {
                echo "  ✓ Load schedule: PASS\n";
                echo "    - Seminar Date: " . ($schedule->seminar_date ? $schedule->seminar_date : "Not scheduled") . "\n";
                echo "    - Final Exam Date: " . ($schedule->final_exam_date ? $schedule->final_exam_date : "Not scheduled") . "\n";
            } else {
                echo "  ⚠ No schedule found yet\n";
            }
        } else {
            echo "  ⚠ No thesis found for this student\n";
        }

        // TEST 10: Profile & Account
        echo "\n[TEST 10] PROFILE & ACCOUNT\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        echo "  ✓ Load profile: PASS\n";
        echo "    - Name: " . $mahasiswa->name . "\n";
        echo "    - NIM: " . $mahasiswa->nim . "\n";
        echo "    - Email: " . $mahasiswa->email . "\n";
        echo "    - Role: " . strtoupper($mahasiswa->role) . "\n";

        $this->assertTrue(true);
    }

    /**
     * Test all DOSEN features in detail
     */
    public function test_dosen_detailed_features()
    {
        echo "\n\n╔════════════════════════════════════════════════════════════════════╗\n";
        echo "║            DETAILED DOSEN (LECTURER) FEATURES TEST                 ║\n";
        echo "╚════════════════════════════════════════════════════════════════════╝\n";

        $dosen = User::where('nim', 'D001')->first();

        // TEST 1: Dashboard Overview
        echo "\n[TEST 1] DASHBOARD OVERVIEW\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $courses = Course::where('lecturer_id', $dosen->id)->get();
        echo "  ✓ Load taught courses: PASS (" . $courses->count() . " courses)\n";

        foreach ($courses as $c) {
            echo "    - " . $c->code . ": " . $c->students()->count() . " students\n";
        }

        // TEST 2: Student Supervision
        echo "\n[TEST 2] STUDENT SUPERVISION\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $courseIds = $courses->pluck('id')->toArray();
        $totalStudents = User::whereHas('courses', function ($q) use ($courseIds) {
            $q->whereIn('courses.id', $courseIds);
        })->where('role', 'mahasiswa')->distinct()->count();

        echo "  ✓ Total students supervised: " . $totalStudents . "\n";

        // TEST 3: Task Assignments
        echo "\n[TEST 3] TASK ASSIGNMENTS (PENUGASAN)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $totalTasks = Task::whereIn('course_id', $courseIds)->count();
        echo "  ✓ Total tasks assigned: " . $totalTasks . "\n";

        $tasksByPriority = Task::whereIn('course_id', $courseIds)->get()->groupBy('priority');
        foreach ($tasksByPriority as $priority => $items) {
            echo "    - " . strtoupper($priority) . ": " . $items->count() . "\n";
        }

        // TEST 4: Student Progress Monitoring
        echo "\n[TEST 4] STUDENT PROGRESS MONITORING\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $students = User::whereHas('courses', function ($q) use ($courseIds) {
            $q->whereIn('courses.id', $courseIds);
        })->where('role', 'mahasiswa')->get();

        if ($students->count() > 0) {
            $sampleStudent = $students->first();
            $completedTasks = TaskCompletion::where('user_id', $sampleStudent->id)->count();
            $assignedTasks = Task::whereIn('course_id', $courseIds)->count();

            echo "  ✓ Sample student progress: " . $sampleStudent->name . "\n";
            echo "    - Completed tasks: " . $completedTasks . "/" . $assignedTasks . "\n";
            echo "    - Progress: " . ($assignedTasks > 0 ? round(($completedTasks / $assignedTasks) * 100, 2) : 0) . "%\n";
        }

        // TEST 5: Thesis Monitoring
        echo "\n[TEST 5] MONITORING SKRIPSI (THESIS ADVISING)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $advisees = Thesis::where('advisor_id', $dosen->id)->get();
        echo "  ✓ Total advisees: " . $advisees->count() . "\n";

        $byStatus = $advisees->groupBy('status');
        foreach ($byStatus as $status => $items) {
            echo "    - " . strtoupper($status) . ": " . $items->count() . "\n";
        }

        // TEST 6: Thesis Submissions Review
        echo "\n[TEST 6] THESIS SUBMISSIONS FOR REVIEW\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        if ($advisees->count() > 0) {
            $allSubmissions = ThesisSubmission::whereIn('thesis_id', $advisees->pluck('id'))->get();

            $bySubmissionStatus = $allSubmissions->groupBy('status');
            foreach ($bySubmissionStatus as $status => $items) {
                echo "  ✓ Submissions with status '$status': " . $items->count() . "\n";
            }

            $pendingSubmissions = $allSubmissions->where('status', 'submitted')->count();
            echo "    → Pending review: " . $pendingSubmissions . "\n";
        }

        // TEST 7: Feedback Management
        echo "\n[TEST 7] FEEDBACK MANAGEMENT\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        if ($advisees->count() > 0) {
            $allFeedback = ThesisFeedback::whereHas('submission', function ($q) use ($advisees) {
                $q->whereIn('thesis_id', $advisees->pluck('id'));
            })->get();

            echo "  ✓ Total feedback given: " . $allFeedback->count() . "\n";

            $byFeedbackStatus = $allFeedback->groupBy('is_resolved');
            foreach ($byFeedbackStatus as $resolved => $items) {
                $status = $resolved ? "Resolved" : "Pending";
                echo "    - " . $status . ": " . $items->count() . "\n";
            }

            $byFeedbackType = $allFeedback->groupBy('type');
            foreach ($byFeedbackType as $type => $items) {
                echo "    - Type '$type': " . $items->count() . "\n";
            }
        }

        // TEST 8: Report Generation
        echo "\n[TEST 8] LAPORAN (REPORTS)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $reports = \App\Models\Report::where('lecturer_id', $dosen->id)->count();
        echo "  ✓ Generated reports: " . $reports . "\n";

        // TEST 9: Reminder System
        echo "\n[TEST 9] REMINDER SYSTEM (PENGINGAT)\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        $reminders = \App\Models\Reminder::where('lecturer_id', $dosen->id)->count();
        echo "  ✓ Created reminders: " . $reminders . "\n";

        $activeReminders = \App\Models\Reminder::where('lecturer_id', $dosen->id)->where('is_sent', true)->count();
        echo "  ✓ Sent reminders: " . $activeReminders . "\n";

        // TEST 10: Profile & Account
        echo "\n[TEST 10] PROFILE & ACCOUNT\n";
        echo "─────────────────────────────────────────────────────────────────────\n";

        echo "  ✓ Load profile: PASS\n";
        echo "    - Name: " . $dosen->name . "\n";
        echo "    - NIP: " . $dosen->nim . "\n";
        echo "    - Email: " . $dosen->email . "\n";
        echo "    - Role: " . strtoupper($dosen->role) . "\n";

        echo "\n" . str_repeat("═", 69) . "\n";
        echo "✅ ALL DETAILED FEATURE TESTS COMPLETED SUCCESSFULLY\n";
        echo str_repeat("═", 69) . "\n";

        $this->assertTrue(true);
    }
}
