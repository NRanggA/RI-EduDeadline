<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Event;
use App\Models\Activity;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Get month and year from request or use current date
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Validate month and year
        $year = (int) $year;
        $month = (int) $month;

        if ($month < 1 || $month > 12) {
            $month = now()->month;
            $year = now()->year;
        }

        // Create date objects for navigation
        $currentDate = Carbon::createFromDate($year, $month, 1);
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
        $prevYear = $currentDate->copy()->subYear();
        $nextYear = $currentDate->copy()->addYear();

        // Get calendar days
        $calendarDays = $this->getCalendarDays($currentDate);

        // Get all tasks and events for the month
        $daysWithData = $this->getDaysWithData($user, $currentDate);

        // Get activities for the month
        $activities = Activity::where('user_id', $user->id)
            ->whereBetween('date', [$currentDate->copy()->startOfMonth(), $currentDate->copy()->endOfMonth()])
            ->get()
            ->groupBy(function ($activity) {
                return $activity->date->day;
            });

        // Get today for highlighting
        $today = now();
        $isCurrentMonth = $today->year === $year && $today->month === $month;

        return view('mahasiswa.calendar', compact(
            'currentDate',
            'calendarDays',
            'daysWithData',
            'activities',
            'today',
            'isCurrentMonth',
            'year',
            'month',
            'prevMonth',
            'nextMonth',
            'prevYear',
            'nextYear'
        ));
    }

    /**
     * Generate calendar days for the month
     */
    private function getCalendarDays(Carbon $date): array
    {
        $firstDay = $date->copy()->startOfMonth();
        $lastDay = $date->copy()->endOfMonth();

        $daysInMonth = $lastDay->day;
        $startingDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday

        $days = [];
        $dayCount = 1;

        // Create 6 weeks x 7 days grid
        for ($week = 0; $week < 6; $week++) {
            for ($day = 0; $day < 7; $day++) {
                $cellIndex = $week * 7 + $day;

                if ($cellIndex < $startingDayOfWeek || $dayCount > $daysInMonth) {
                    $days[] = null;
                } else {
                    $days[] = $dayCount++;
                }
            }
        }

        return $days;
    }

    /**
     * Get days with tasks and events
     */
    private function getDaysWithData($user, Carbon $currentDate): array
    {
        $courseIds = $user->courses->pluck('id');

        // Get all tasks for the month
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $tasks = Task::whereIn('course_id', $courseIds)
            ->whereBetween('deadline', [$startOfMonth, $endOfMonth])
            ->where('status', '!=', 'completed')
            ->get()
            ->groupBy(function ($task) {
                return $task->deadline->day;
            });

        // Get all events for the month
        $events = Event::where('user_id', $user->id)
            ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function ($event) {
                return $event->start_date->day;
            });

        // Merge data
        $daysWithData = [];
        foreach ($tasks as $day => $dayTasks) {
            if (!isset($daysWithData[$day])) {
                $daysWithData[$day] = ['tasks' => [], 'events' => []];
            }
            $daysWithData[$day]['tasks'] = $dayTasks;
        }

        foreach ($events as $day => $dayEvents) {
            if (!isset($daysWithData[$day])) {
                $daysWithData[$day] = ['tasks' => [], 'events' => []];
            }
            $daysWithData[$day]['events'] = $dayEvents;
        }

        return $daysWithData;
    }

    /**
     * Store a new event
     */
    public function storeEvent(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date_format:Y-m-d\TH:i',
            'end_date' => 'nullable|date_format:Y-m-d\TH:i|after:start_date',
            'type' => 'required|in:event,reminder,note',
        ]);

        Event::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'type' => $validated['type'],
            'color' => 'orange',
        ]);

        return redirect()->back()->with('success', 'Event berhasil ditambahkan!');
    }
}
