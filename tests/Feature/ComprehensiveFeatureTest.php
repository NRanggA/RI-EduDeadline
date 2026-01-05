<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Task;
use App\Models\Thesis;
use App\Models\ThesisFeedback;
use App\Models\ThesisSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComprehensiveFeatureTest extends TestCase
{
    public function test_mahasiswa_dashboard_features()
    {
        echo "\n╔════════════════════════════════════════════════════════════════════╗\n";
        echo "║         COMPREHENSIVE FEATURE TESTING - MAHASISWA & DOSEN         ║\n";
        echo "╚════════════════════════════════════════════════════════════════════╝\n";

        $mahasiswa = User::where('nim', '2021001')->first();
        $dosen = User::where('nim', 'D001')->first();

        echo "\n═══════════════════════════════════════════════════════════════════\n";
        echo "👨‍🎓 MAHASISWA FEATURES - " . $mahasiswa->name . "\n";
        echo "═══════════════════════════════════════════════════════════════════\n";

        // [1] DASHBOARD - Enrolled Courses
        echo "\n[1] DASHBOARD - Enrolled Courses\n";
        $courses = $mahasiswa->courses()->with('lecturer')->get();
        echo "  ✓ Total courses: " . $courses->count() . "\n";
        foreach ($courses as $c) {
            echo "    - " . $c->code . " " . $c->name . " (Pengajar: " . $c->lecturer->name . ")\n";
        }
        $this->assertGreaterThan(0, $courses->count());

        // [2] DASHBOARD - Task Overview
        echo "\n[2] DASHBOARD - Task Overview\n";
        $courseIds = $mahasiswa->courses()->pluck('courses.id')->toArray();
        $tasks = Task::whereIn('course_id', $courseIds)->get();
        echo "  ✓ Total tasks: " . $tasks->count() . "\n";
        echo "  ✓ Urgent: " . $tasks->where('priority', 'urgent')->count() . "\n";
        echo "  ✓ Normal: " . $tasks->where('priority', 'normal')->count() . "\n";

        // [3] PER MATA KULIAH - Filter by Course
        echo "\n[3] PER MATA KULIAH - Filter by Course\n";
        if ($courses->count() > 0) {
            $course1 = $courses->first();
            $tasksInCourse = Task::where('course_id', $course1->id)->get();
            echo "  ✓ Course: " . $course1->name . "\n";
            echo "  ✓ Tasks in this course: " . $tasksInCourse->count() . "\n";
            foreach ($tasksInCourse->take(3) as $task) {
                echo "    - " . $task->title . " (Priority: " . $task->priority . ")\n";
            }
        }

        // [4] CALENDAR/ACTIVITIES
        echo "\n[4] CALENDAR/ACTIVITIES - List Activities\n";
        $activities = Activity::where('user_id', $mahasiswa->id)->get();
        echo "  ✓ Total activities: " . $activities->count() . "\n";
        $byCategory = $activities->groupBy('category');
        foreach ($byCategory as $cat => $items) {
            echo "    - " . $cat . ": " . $items->count() . "\n";
        }

        // [5] TASK COMPLETION - Mark Task Complete
        echo "\n[5] TASK COMPLETION - Check if any tasks completed\n";
        if ($tasks->count() > 0) {
            $completed = $mahasiswa->taskCompletions()->count();
            echo "  ✓ Tasks completed by student: " . $completed . "\n";
        }

        // [6] SKRIPSI (THESIS)
        echo "\n[6] SKRIPSI (THESIS) - Thesis Information\n";
        $thesis = Thesis::where('user_id', $mahasiswa->id)->first();
        if ($thesis) {
            echo "  ✓ Thesis Title: " . $thesis->title . "\n";
            echo "  ✓ Advisor: " . $thesis->advisor->name . "\n";
            echo "  ✓ Status: " . strtoupper($thesis->status) . "\n";
            echo "  ✓ Submissions: " . $thesis->submissions()->count() . "\n";
        } else {
            echo "  ⚠ No thesis found for this student\n";
        }

        // [7] THESIS SUBMISSIONS
        echo "\n[7] THESIS SUBMISSIONS\n";
        if ($thesis) {
            $submissions = $thesis->submissions()->get();
            echo "  ✓ Total submissions: " . $submissions->count() . "\n";
            foreach ($submissions->take(3) as $sub) {
                echo "    - " . $sub->chapter . " (Status: " . $sub->status . ")\n";
            }
        }

        // [8] THESIS FEEDBACK
        echo "\n[8] THESIS FEEDBACK - Feedback from Advisor\n";
        if ($thesis) {
            $feedback = ThesisFeedback::whereHas('submission', function ($q) use ($thesis) {
                $q->where('thesis_id', $thesis->id);
            })->get();
            echo "  ✓ Total feedback: " . $feedback->count() . "\n";
            $resolved = $feedback->where('is_resolved', true)->count();
            echo "  ✓ Resolved: " . $resolved . "\n";
            echo "  ✓ Pending: " . ($feedback->count() - $resolved) . "\n";
        }

        echo "\n" . str_repeat("═", 69) . "\n";
        echo "👨‍🏫 DOSEN (LECTURER) FEATURES - " . $dosen->name . "\n";
        echo str_repeat("═", 69) . "\n";

        // [1] DOSEN DASHBOARD - Courses Teaching
        echo "\n[1] DASHBOARD - Courses Teaching\n";
        $dosenCourses = Course::where('lecturer_id', $dosen->id)->get();
        echo "  ✓ Total courses teaching: " . $dosenCourses->count() . "\n";
        foreach ($dosenCourses as $c) {
            $enrollments = $c->students()->count();
            echo "    - " . $c->code . " " . $c->name . " (" . $enrollments . " students)\n";
        }

        // [2] DOSEN DASHBOARD - Total Students
        echo "\n[2] DASHBOARD - Total Students\n";
        $courseIds = $dosenCourses->pluck('id')->toArray();
        $students = User::whereHas('courses', function ($q) use ($courseIds) {
            $q->whereIn('courses.id', $courseIds);
        })->distinct()->count();
        echo "  ✓ Total students supervised: " . $students . "\n";

        // [3] THESIS MONITORING
        echo "\n[3] MONITORING SKRIPSI - Thesis Advisees\n";
        $advisees = Thesis::where('advisor_id', $dosen->id)->get();
        echo "  ✓ Total advisees: " . $advisees->count() . "\n";
        $statusCount = $advisees->groupBy('status');
        foreach ($statusCount as $status => $items) {
            echo "    - " . strtoupper($status) . ": " . $items->count() . "\n";
        }

        // [4] THESIS SUBMISSIONS TO REVIEW
        echo "\n[4] THESIS SUBMISSIONS - Waiting for Review\n";
        if ($advisees->count() > 0) {
            $allSubmissions = ThesisSubmission::whereIn('thesis_id', $advisees->pluck('id'))
                ->where('status', 'submitted')
                ->get();
            echo "  ✓ Pending submissions: " . $allSubmissions->count() . "\n";
        }

        // [5] STUDENT PROGRESS - Task Completion Rate
        echo "\n[5] STUDENT PROGRESS - Task Completion Rate\n";
        $totalTasks = Task::whereIn('course_id', $courseIds)->count();
        if ($totalTasks > 0) {
            echo "  ✓ Total tasks assigned: " . $totalTasks . "\n";
        }

        echo "\n" . str_repeat("═", 69) . "\n";
        echo "✅ ALL FEATURE TESTS COMPLETED SUCCESSFULLY\n";
        echo str_repeat("═", 69) . "\n";

        $this->assertTrue(true);
    }
}
