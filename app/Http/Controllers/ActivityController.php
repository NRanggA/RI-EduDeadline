<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new activity
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Kuliah,Event Organisasi',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string',
        ]);

        // Create activity instance
        $activity = new Activity([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'category' => $validated['category'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'description' => $validated['description'] ?? null,
        ]);

        // Check for conflicts
        if ($activity->hasConflict()) {
            $conflicts = $activity->getConflicts();

            return back()
                ->withInput()
                ->with([
                    'conflict' => true,
                    'conflictActivities' => $conflicts->toArray(),
                    'newActivity' => [
                        'name' => $activity->name,
                        'start_time' => $activity->start_time,
                        'end_time' => $activity->end_time,
                        'date' => $activity->date,
                    ]
                ]);
        }

        // Save activity
        $activity->save();

        return redirect()->route('mahasiswa.calendar', [
            'year' => Carbon::parse($validated['date'])->year,
            'month' => Carbon::parse($validated['date'])->month,
        ])->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Get activities for a specific date
     */
    public function getByDate(Request $request)
    {
        $user = Auth::user();
        $date = $request->get('date');

        $activities = Activity::where('user_id', $user->id)
            ->where('date', $date)
            ->orderBy('start_time')
            ->get();

        return response()->json($activities);
    }

    /**
     * Delete an activity
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        $this->authorize('delete', $activity);

        $activity->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}
