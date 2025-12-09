<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Course;
use App\Models\TaskCompletion;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Get all course IDs the user is enrolled in
        $courseIds = $user->courses->pluck('id');

        // Get all tasks for enrolled courses
        $allTasks = Task::whereIn('course_id', $courseIds)
            ->with('course', 'creator')
            ->where('status', '!=', 'completed')
            ->get();

        // Count urgent tasks (priority = 'urgent' AND not completed)
        $urgentCount = $allTasks->where('priority', 'urgent')->count();

        // Get total active tasks (not completed)
        $totalTasks = $allTasks->count();

        // Get tasks completed this week (include submitted and approved)
        $weekAgo = Carbon::now()->subWeek();
        $completedThisWeek = TaskCompletion::where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'approved'])
            ->where('updated_at', '>=', $weekAgo)
            ->count();

        // Apply filters
        $filteredTasks = $allTasks;

        // Filter by priority
        if ($request->has('priority') && $request->get('priority') !== '') {
            $filteredTasks = $filteredTasks->where('priority', $request->get('priority'));
        }

        // Filter by date range
        $range = $request->get('range', 'month');
        if ($range === '3days') {
            // Next 3 days
            $filteredTasks = $filteredTasks->filter(function ($task) {
                return $task->deadline >= now() && $task->deadline <= now()->addDays(3);
            });
        } elseif ($range === 'month') {
            // Next 30 days
            $filteredTasks = $filteredTasks->filter(function ($task) {
                return $task->deadline >= now() && $task->deadline <= now()->addDays(30);
            });
        }
        // else: 'all' - show all tasks

        // Sort by priority (urgent first) then by deadline
        $upcomingTasks = $filteredTasks->sortBy(function ($task) {
            $priorityOrder = ['urgent' => 0, 'normal' => 1, 'rendah' => 2];
            return [$priorityOrder[$task->priority] ?? 999, $task->deadline];
        })->take(10); // Limit to 10 tasks for dashboard

        return view('mahasiswa.dashboard', compact(
            'urgentCount',
            'totalTasks',
            'completedThisWeek',
            'upcomingTasks'
        ));
    }

    public function focusMode()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        return view('mahasiswa.focus-mode', compact('thesis'));
    }

    public function uploadProgress()
    {
        return view('mahasiswa.upload-progress');
    }

    public function profile()
    {
        return view('mahasiswa.profile');
    }
}
