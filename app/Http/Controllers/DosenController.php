<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Task;
use App\Models\TaskCompletion;
use App\Models\Reminder;
use App\Models\User;
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

        // Calculate statistics
        $statistics = [
            'total_courses' => $courses->count(),
            'total_tasks' => $tasks->count(),
            'pending_tasks' => $tasks->filter(fn($t) => $t->status === 'pending')->count(),
            'overdue_tasks' => $tasks->filter(fn($t) => $t->status === 'overdue')->count(),
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

        return view('dosen.dashboard', compact('courses', 'tasks', 'statistics', 'task_stats'));
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
            'course_id' => 'required|exists:courses,id',
            'recipient_type' => 'required|in:semua_mahasiswa,belum_mengumpulkan,terlambat',
            'title' => 'required|string|max:255',
            'template_pesan' => 'required|string|max:1000',
            'waktu_pengingat' => 'nullable|date_format:Y-m-d H:i',
        ], [
            'course_id.required' => 'Pilih mata kuliah',
            'recipient_type.required' => 'Pilih tipe penerima reminder',
            'title.required' => 'Judul reminder harus diisi',
            'template_pesan.required' => 'Template pesan harus diisi',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Verify that this lecturer owns this course
        if ($course->lecturer_id !== $dosen->id) {
            return back()->with('error', 'Anda tidak memiliki akses ke kursus ini');
        }

        // Determine which students should receive the reminder
        $students = $this->getRecipientStudents(
            $course->id,
            $validated['recipient_type']
        );

        // Create reminder record
        $reminder = Reminder::create([
            'course_id' => $course->id,
            'lecturer_id' => $dosen->id,
            'title' => $validated['title'],
            'message' => $validated['template_pesan'],
            'recipient_type' => $this->mapRecipientType($validated['recipient_type']),
            'scheduled_at' => $validated['waktu_pengingat'] ? Carbon::parse($validated['waktu_pengingat']) : now(),
            'is_sent' => true,
            'sent_at' => now(),
        ]);

        // Attach recipients
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


    public function laporan()
    {
        return view('dosen.laporan');
    }

    public function profile()
    {
        return view('dosen.profile');
    }
}
