<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Course;
use App\Models\TaskCompletion;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Screen 3: Detail Tugas
    public function show($id)
    {
        $task = Task::with('course', 'creator')->findOrFail($id);
        $user = auth()->user();

        // Get user's completion status for this task
        $completion = $task->completions()
            ->where('user_id', $user->id)
            ->first();

        return view('mahasiswa.detail-tugas', compact('task', 'completion'));
    }

    // Mark task as completed
    public function complete($id)
    {
        $task = Task::findOrFail($id);
        $user = auth()->user();

        // Check if user is enrolled in this course
        if (!$user->courses->contains($task->course_id)) {
            abort(403, 'Unauthorized');
        }

        // Create or update completion record
        $completion = TaskCompletion::updateOrCreate(
            [
                'task_id' => $task->id,
                'user_id' => $user->id,
            ],
            [
                'status' => 'submitted',
                'completed_at' => now(),
                'submission_notes' => 'Tugas dikumpulkan melalui sistem',
            ]
        );

        return redirect()->route('mahasiswa.tugas.detail', ['id' => $task->id])
            ->with('success', 'Tugas berhasil ditandai sebagai selesai!');
    }

    // Update task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $user = auth()->user();

        // Check if user is enrolled in this course
        if (!$user->courses->contains($task->course_id)) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:rendah,normal,urgent',
        ]);

        $task->update($validated);

        return redirect()->route('mahasiswa.tugas.detail', ['id' => $task->id])
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    // Screen 4: Per Mata Kuliah (HMW 4 - Proximity)
    public function perMataKuliah()
    {
        $user = auth()->user();

        // Get all courses for the logged-in user
        $courses = $user->courses()
            ->with(['tasks' => function ($query) {
                $query->where('status', '!=', 'completed')
                    ->orderBy('deadline', 'asc');
            }])
            ->get();

        // Map courses with task details and progress
        $coursesData = $courses->map(function ($course) use ($user) {
            return (object) [
                'id' => $course->id,
                'name' => $course->name,
                'code' => $course->code,
                'icon' => $course->icon ?? '📘',
                'tasks' => $course->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'deadline' => $task->deadline->format('d M Y H:i'),
                        'priority' => $task->priority,
                        'status' => $task->status,
                        'days_remaining' => $task->days_remaining,
                    ];
                })->toArray(),
                'progress' => $course->getStudentProgress($user->id),
                'total_tasks' => $course->tasks()->count(),
                'completed_tasks' => $course->tasks()
                    ->whereHas('completions', function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->whereIn('status', ['submitted', 'approved']);
                    })
                    ->count(),
            ];
        });

        return view('mahasiswa.per-mk', ['courses' => $coursesData]);
    }

    // Screen 5: Weekly Overview
    public function weekly()
    {
        $user = auth()->user();
        $courses = $user->courses()->get();

        // Get all tasks for the next 7 days
        $startDate = now()->startOfDay();
        $endDate = now()->addDays(7)->endOfDay();

        $tasks = Task::whereIn('course_id', $courses->pluck('id'))
            ->where('status', '!=', 'completed')
            ->whereBetween('deadline', [$startDate, $endDate])
            ->with('course')
            ->orderBy('deadline', 'asc')
            ->get();

        // Group tasks by day
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = now()->addDays($i)->startOfDay();
            $dayName = $date->format('l (d)'); // e.g., "Monday (08)"

            $dayTasks = $tasks->filter(function ($task) use ($date) {
                return $task->deadline->isSameDay($date);
            })->map(function ($task) {
                return [
                    'icon' => $task->course->icon ?? '📘',
                    'title' => $task->title,
                    'course' => $task->course->code,
                    'time' => $task->deadline->format('H:i'),
                    'priority' => $task->priority,
                ];
            })->values();

            $days[] = (object) [
                'day' => $dayName,
                'tasks' => $dayTasks->toArray(),
                'heavy' => count($dayTasks) > 2, // Mark as heavy if more than 2 tasks
            ];
        }

        return view('mahasiswa.weekly', compact('days'));
    }

    // CRUD methods
    public function index()
    {
        // List semua tugas
    }

    public function create()
    {
        // Form tambah tugas
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:rendah,normal,urgent',
        ]);

        $user = auth()->user();

        // Check if user is enrolled in this course
        if (!$user->courses->contains($validated['course_id'])) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di mata kuliah ini');
        }

        // Create task
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'course_id' => $validated['course_id'],
            'deadline' => $validated['deadline'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        return redirect()->route('mahasiswa.tugas.detail', ['id' => $task->id])
            ->with('success', 'Tugas berhasil dibuat!');
    }

    public function edit($id)
    {
        // Form edit tugas
    }

    public function destroy($id)
    {
        // Hapus tugas
    }
}
