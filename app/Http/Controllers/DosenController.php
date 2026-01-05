<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\Reminder;
use App\Models\Report;
use App\Models\User;
use App\Models\Thesis;
use App\Models\ThesisSubmission;
use App\Models\ThesisFeedback;
use Carbon\Carbon;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dosen = Auth::user();

        // Get all courses taught by this lecturer
        $courses = Course::where('lecturer_id', $dosen->id)
            ->with(['tasks' => function ($query) {
                $query->orderBy('deadline', 'asc');
            }])
            ->get();

        // Get all tasks created by this lecturer
        $tasks = Task::where('created_by', $dosen->id)
            ->with(['course', 'completions'])
            ->orderBy('deadline', 'asc')
            ->get();

        // Get all thesis where this lecturer is advisor (pembimbing)
        $advisedTheses = Thesis::where('advisor_id', $dosen->id)
            ->orWhere('co_advisor_id', $dosen->id)
            ->with(['student', 'submissions', 'advisor', 'coAdvisor'])
            ->orderBy('defense_deadline', 'asc')
            ->get();

        // Get thesis submissions and feedback data
        $thesisData = [];
        foreach ($advisedTheses as $thesis) {
            // Get latest submissions for each chapter
            $latestSubmissions = $thesis->submissions()
                ->selectRaw('chapter, MAX(version) as max_version')
                ->groupBy('chapter')
                ->get();

            $submissions = [];
            foreach ($latestSubmissions as $latest) {
                $submission = $thesis->submissions()
                    ->where('chapter', $latest->chapter)
                    ->where('version', $latest->max_version)
                    ->first();

                if ($submission) {
                    $feedbackCount = ThesisFeedback::where('thesis_submission_id', $submission->id)
                        ->where('is_resolved', 0)
                        ->count();

                    $submissions[] = [
                        'id' => $submission->id,
                        'chapter' => $submission->chapter,
                        'title' => $submission->title,
                        'status' => $submission->status,
                        'version' => $submission->version,
                        'created_at' => $submission->created_at,
                        'unresolved_feedback' => $feedbackCount,
                    ];
                }
            }

            // Count unresolved feedback
            $totalUnresolvedFeedback = ThesisFeedback::whereIn(
                'thesis_submission_id',
                $thesis->submissions()->pluck('id')
            )
                ->where('is_resolved', 0)
                ->count();

            $thesisData[] = [
                'thesis' => $thesis,
                'student_name' => $thesis->student->name,
                'submissions' => $submissions,
                'submitted_chapters' => count($submissions),
                'total_chapters' => 5,
                'unresolved_feedback' => $totalUnresolvedFeedback,
                'defense_deadline' => $thesis->defense_deadline,
                'days_until_defense' => $thesis->defense_deadline ? now()->diffInDays($thesis->defense_deadline, false) : null,
            ];
        }

        // Calculate statistics
        $statistics = [
            'total_courses' => $courses->count(),
            'total_tasks' => $tasks->count(),
            'pending_tasks' => $tasks->filter(fn($t) => $t->status === 'pending')->count(),
            'overdue_tasks' => $tasks->filter(fn($t) => $t->status === 'overdue')->count(),
            'total_students' => $advisedTheses->count(),
            'pending_defense' => $advisedTheses->filter(fn($t) => $t->status !== 'completed')->count(),
        ];

        // Get task completion statistics
        $task_stats = [];
        foreach ($tasks as $task) {
            $completions = $task->completions;
            $enrolled_students = $task->course->students->count();

            $task_stats[] = [
                'task' => $task,
                'total_enrolled' => $enrolled_students,
                'submitted' => $completions->count(),
                'pending' => $enrolled_students - $completions->count(),
                'approved' => $completions->where('status', 'approved')->count(),
                'rejected' => $completions->where('status', 'rejected')->count(),
            ];
        }

        return view('dosen.dashboard', compact('courses', 'tasks', 'statistics', 'task_stats', 'thesisData'));
    }

    /**
     * Monitoring Skripsi Mahasiswa
     */
    public function monitoringSkripsi()
    {
        $dosen = Auth::user();

        // Get all thesis where this lecturer is advisor (pembimbing)
        $advisedTheses = Thesis::where('advisor_id', $dosen->id)
            ->orWhere('co_advisor_id', $dosen->id)
            ->with(['student', 'submissions', 'advisor', 'coAdvisor'])
            ->orderBy('defense_deadline', 'asc')
            ->get();

        // Get thesis submissions and feedback data with detailed info
        $thesisMonitoring = [];
        foreach ($advisedTheses as $thesis) {
            // Get latest submissions for each chapter
            $latestSubmissions = $thesis->submissions()
                ->selectRaw('chapter, MAX(version) as max_version')
                ->groupBy('chapter')
                ->get();

            $submissions = [];
            foreach ($latestSubmissions as $latest) {
                $submission = $thesis->submissions()
                    ->where('chapter', $latest->chapter)
                    ->where('version', $latest->max_version)
                    ->first();

                if ($submission) {
                    $feedbacks = ThesisFeedback::where('thesis_submission_id', $submission->id)
                        ->with('advisor')
                        ->get();

                    $submissions[] = [
                        'id' => $submission->id,
                        'chapter' => $submission->chapter,
                        'title' => $submission->title,
                        'status' => $submission->status,
                        'version' => $submission->version,
                        'created_at' => $submission->created_at,
                        'total_feedback' => $feedbacks->count(),
                        'unresolved_feedback' => $feedbacks->where('is_resolved', 0)->count(),
                        'feedbacks' => $feedbacks,
                    ];
                }
            }

            // Count all feedback
            $allFeedbacks = ThesisFeedback::whereIn(
                'thesis_submission_id',
                $thesis->submissions()->pluck('id')
            )->get();

            $totalUnresolvedFeedback = $allFeedbacks->where('is_resolved', 0)->count();
            $totalFeedback = $allFeedbacks->count();

            $thesisMonitoring[] = [
                'id' => $thesis->id,
                'thesis' => $thesis,
                'student_name' => $thesis->student->name,
                'student_nim' => $thesis->student->nim,
                'submissions' => $submissions,
                'submitted_chapters' => count($submissions),
                'total_chapters' => 5,
                'progress_percentage' => (count($submissions) / 5) * 100,
                'total_feedback' => $totalFeedback,
                'unresolved_feedback' => $totalUnresolvedFeedback,
                'defense_deadline' => $thesis->defense_deadline,
                'days_until_defense' => $thesis->defense_deadline ? now()->diffInDays($thesis->defense_deadline, false) : null,
                'status' => $thesis->status,
                'advisor_role' => $thesis->advisor_id === $dosen->id ? 'Pembimbing Utama' : 'Pembimbing Kedua',
            ];
        }

        // Calculate statistics
        $statistics = [
            'total_students' => count($thesisMonitoring),
            'completed_defense' => collect($thesisMonitoring)->where('status', 'completed')->count(),
            'pending_defense' => collect($thesisMonitoring)->where('status', '!=', 'completed')->count(),
            'total_feedback_pending' => collect($thesisMonitoring)->sum('unresolved_feedback'),
            'overdue_defense' => collect($thesisMonitoring)->filter(fn($t) => $t['days_until_defense'] !== null && $t['days_until_defense'] < 0)->count(),
        ];

        return view('dosen.monitoring-skripsi', compact('thesisMonitoring', 'statistics'));
    }

    public function reminder()
    {
        $dosen = Auth::user();

        // Get all courses taught by this lecturer
        $courses = Course::where('lecturer_id', $dosen->id)
            ->with(['tasks', 'students'])
            ->get();

        // Get previous reminders sent
        $previous_reminders = Reminder::where('lecturer_id', $dosen->id)
            ->with(['course', 'recipients'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get task completion data for reminder setup
        $task_data = [];
        foreach ($courses as $course) {
            foreach ($course->tasks as $task) {
                $completions = TaskCompletion::where('task_id', $task->id)->get();
                $enrolled_students = $course->students->count();

                $task_data[] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'course' => $course,
                    'deadline' => $task->deadline,
                    'total_enrolled' => $enrolled_students,
                    'submitted' => $completions->count(),
                    'not_submitted' => $enrolled_students - $completions->count(),
                    'overdue' => $completions->where('status', '!=', 'approved')->count(),
                    'students_not_submitted' => $this->getStudentsNotSubmitted($task->id, $course->id),
                    'students_overdue' => $this->getStudentsOverdue($task->id, $course->id),
                ];
            }
        }

        return view('dosen.reminder', compact('courses', 'task_data', 'previous_reminders'));
    }

    public function sendReminder(Request $request)
    {
        $dosen = Auth::user();

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'recipient_type' => 'required|in:semua_mahasiswa,belum_mengumpulkan,terlambat',
            'title' => 'required|string|max:255',
            'template_pesan' => 'required|string|max:1000',
            'waktu_pengingat' => 'nullable|date_format:Y-m-d H:i',
        ], [
            'course_name.required' => 'Nama mata kuliah harus diisi',
            'recipient_type.required' => 'Pilih tipe penerima reminder',
            'title.required' => 'Judul reminder harus diisi',
            'template_pesan.required' => 'Template pesan harus diisi',
        ]);

        // Tidak ada relasi ke tabel courses, reminder dikirim ke semua mahasiswa (atau sesuai filter) tanpa filter course_id
        $students = User::where('role', 'mahasiswa')->get();

        $reminder = Reminder::create([
            'course_id' => null,
            'course_name' => $validated['course_name'],
            'lecturer_id' => $dosen->id,
            'title' => $validated['title'],
            'message' => $validated['template_pesan'],
            'recipient_type' => $validated['recipient_type'],
            'scheduled_at' => $validated['waktu_pengingat'] ? Carbon::parse($validated['waktu_pengingat']) : now(),
            'is_sent' => true,
            'sent_at' => now(),
        ]);

        foreach ($students as $student) {
            $reminder->recipients()->attach($student->id);
        }

        return back()->with('success', 'Reminder berhasil dikirim ke ' . $students->count() . ' mahasiswa!');
    }

    /**
     * Get students who should receive the reminder
     */
    private function getRecipientStudents($courseId, $recipientType)
    {
        $course = Course::findOrFail($courseId);
        $all_students = $course->students;

        if ($recipientType === 'semua_mahasiswa') {
            return $all_students;
        }

        if ($recipientType === 'belum_mengumpulkan') {
            return $this->filterStudentsNotSubmitted($all_students, $courseId);
        }

        if ($recipientType === 'terlambat') {
            return $this->filterStudentsOverdue($all_students, $courseId);
        }

        return $all_students;
    }

    /**
     * Get students who haven't submitted any task in the course
     */
    private function filterStudentsNotSubmitted($students, $courseId)
    {
        $tasks = Task::where('course_id', $courseId)->pluck('id');

        return $students->filter(function ($student) use ($tasks) {
            $submitted = TaskCompletion::whereIn('task_id', $tasks)
                ->where('user_id', $student->id)
                ->count();
            return $submitted === 0;
        });
    }

    /**
     * Get students with overdue submissions
     */
    private function filterStudentsOverdue($students, $courseId)
    {
        $tasks = Task::where('course_id', $courseId)
            ->where('deadline', '<', now())
            ->pluck('id');

        return $students->filter(function ($student) use ($tasks) {
            $incomplete = TaskCompletion::whereIn('task_id', $tasks)
                ->where('user_id', $student->id)
                ->whereIn('status', ['pending', 'submitted'])
                ->count();
            return $incomplete > 0;
        });
    }

    /**
     * Get students not submitted for a specific task
     */
    private function getStudentsNotSubmitted($taskId, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $all_students = $course->students;
        $submitted_students = TaskCompletion::where('task_id', $taskId)
            ->pluck('user_id');

        return $all_students->whereNotIn('id', $submitted_students);
    }

    /**
     * Get students with overdue submissions for a specific task
     */
    private function getStudentsOverdue($taskId, $courseId)
    {
        $task = Task::findOrFail($taskId);

        if ($task->deadline > now()) {
            return collect([]);
        }

        $course = Course::findOrFail($courseId);
        $all_students = $course->students;

        return $all_students->filter(function ($student) use ($taskId) {
            $completion = TaskCompletion::where('task_id', $taskId)
                ->where('user_id', $student->id)
                ->first();

            return is_null($completion) || in_array($completion->status, ['pending', 'submitted']);
        });
    }

    /**
     * Map recipient type to database format
     */
    private function mapRecipientType($type)
    {
        $mapping = [
            'semua_mahasiswa' => 'all_students',
            'belum_mengumpulkan' => 'not_submitted',
            'terlambat' => 'overdue',
        ];
        return $mapping[$type] ?? 'all_students';
    }


    public function laporan(Request $request)
    {
        $dosen = Auth::user();

        // Get filter parameters
        $period = $request->input('period', 'all');

        // Determine date range based on filter
        $now = now();
        $startDate = match ($period) {
            'bulan_ini' => $now->copy()->startOfMonth(),
            'tiga_bulan' => $now->copy()->subMonths(3)->startOfMonth(),
            'enam_bulan' => $now->copy()->subMonths(6)->startOfMonth(),
            default => $now->copy()->subMonths(6)->startOfMonth(),
        };

        // Get overall reports for this lecturer
        $overallReports = Report::where('lecturer_id', $dosen->id)
            ->whereNull('course_id')
            ->where('period_start', '>=', $startDate)
            ->orderBy('period_end', 'desc')
            ->get();

        // Get course-specific reports
        $courseReports = Report::where('lecturer_id', $dosen->id)
            ->whereNotNull('course_id')
            ->where('period_start', '>=', $startDate)
            ->with('course')
            ->orderBy('period_end', 'desc')
            ->get();

        // Calculate aggregated statistics
        $totalTasks = $overallReports->sum('total_tasks');
        $completedOnTime = $overallReports->sum('completed_on_time');
        $completedLate = $overallReports->sum('completed_late');
        $notSubmitted = $overallReports->sum('not_submitted');

        // Calculate accuracy rate
        $accuracyRate = $totalTasks > 0
            ? round(($completedOnTime / $totalTasks) * 100, 2)
            : 0;

        // Get monthly data for chart
        $monthlyData = Report::where('lecturer_id', $dosen->id)
            ->whereNull('course_id')
            ->where('period_start', '>=', $startDate)
            ->orderBy('period_start', 'asc')
            ->get()
            ->map(function ($report) {
                return [
                    'month' => $report->period_start->format('M'),
                    'accuracy' => $report->accuracy_rate,
                    'completed_on_time' => $report->completed_on_time,
                    'completed_late' => $report->completed_late,
                ];
            });

        // Get breakdown data
        $breakdown = [
            'on_time_percentage' => $totalTasks > 0 ? round(($completedOnTime / $totalTasks) * 100, 1) : 0,
            'late_percentage' => $totalTasks > 0 ? round(($completedLate / $totalTasks) * 100, 1) : 0,
            'not_submitted_percentage' => $totalTasks > 0 ? round(($notSubmitted / $totalTasks) * 100, 1) : 0,
        ];

        return view('dosen.laporan', compact(
            'overallReports',
            'courseReports',
            'totalTasks',
            'completedOnTime',
            'completedLate',
            'notSubmitted',
            'accuracyRate',
            'monthlyData',
            'breakdown',
            'period'
        ));
    }

    public function profile()
    {
        return view('dosen.profile');
    }
}
