<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Thesis;
use App\Models\ThesisSubmission;
use App\Models\ThesisFeedback;
use App\Models\ThesisSchedule;

class SkripsiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show thesis dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            // Create default thesis if not exists
            $thesis = Thesis::create([
                'user_id' => $user->id,
                'title' => 'Skripsi Saya',
                'status' => 'planning',
            ]);
        }

        // Get latest submissions for each chapter
        $submissions = $thesis->submissions()
            ->orderBy('chapter')
            ->latest('version')
            ->get()
            ->unique('chapter');

        // Get upcoming schedule
        $upcomingSchedule = $thesis->schedules()
            ->where('status', '!=', 'completed')
            ->orderBy('defense_date')
            ->first();

        // Get unresolved feedback
        $unresolvedFeedback = ThesisFeedback::whereIn(
            'thesis_submission_id',
            $thesis->submissions()->pluck('id')
        )
            ->where('is_resolved', false)
            ->count();

        return view('mahasiswa.skripsi', compact(
            'thesis',
            'submissions',
            'upcomingSchedule',
            'unresolvedFeedback'
        ));
    }

    /**
     * Show upload chapter page
     */
    public function showUploadForm()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        // Get all chapters with their latest status
        $chapters = $thesis->submissions()
            ->select('chapter', 'title')
            ->distinct()
            ->orderBy('chapter')
            ->get();

        // Get all submissions grouped by chapter
        $submissions = $thesis->submissions()
            ->orderBy('chapter')
            ->orderBy('version', 'desc')
            ->get()
            ->unique('chapter');

        // Default chapters
        $defaultChapters = [
            'Bab 1' => 'Pendahuluan',
            'Bab 2' => 'Tinjauan Pustaka',
            'Bab 3' => 'Metodologi',
            'Bab 4' => 'Hasil dan Pembahasan',
            'Bab 5' => 'Kesimpulan dan Saran',
        ];

        return view('mahasiswa.upload-bab', compact(
            'thesis',
            'chapters',
            'submissions',
            'defaultChapters'
        ));
    }

    /**
     * Upload thesis chapter
     */
    public function uploadChapter(Request $request)
    {
        $validated = $request->validate([
            'chapter' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        // Get latest version for this chapter
        $latestVersion = $thesis->submissions()
            ->where('chapter', $validated['chapter'])
            ->max('version') ?? 0;

        // Store file
        $filePath = $request->file('file')->store('thesis-submissions', 'private');

        // Create submission
        $submission = ThesisSubmission::create([
            'thesis_id' => $thesis->id,
            'user_id' => $user->id,
            'chapter' => $validated['chapter'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'status' => 'submitted',
            'version' => $latestVersion + 1,
        ]);

        return redirect()->route('mahasiswa.skripsi')
            ->with('success', 'Bab berhasil diupload!');
    }

    /**
     * Show feedback page
     */
    public function showFeedback()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        // Get all feedback for all submissions
        $feedback = ThesisFeedback::whereIn(
            'thesis_submission_id',
            $thesis->submissions()->pluck('id')
        )
            ->with('submission', 'advisor')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by submission
        $feedbackBySubmission = $feedback->groupBy('thesis_submission_id');

        return view('mahasiswa.feedback', compact(
            'thesis',
            'feedbackBySubmission'
        ));
    }

    /**
     * Show schedule page
     */
    public function showSchedule()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        $schedule = $thesis->schedules()
            ->with('examiner1', 'examiner2')
            ->orderBy('defense_date')
            ->first();

        return view('mahasiswa.schedule', compact(
            'thesis',
            'schedule'
        ));
    }

    /**
     * Show timeline
     */
    public function timeline()
    {
        $user = Auth::user();
        $thesis = $user->thesis;

        if (!$thesis) {
            abort(404, 'Thesis not found');
        }

        // Get submission timeline
        $submissions = $thesis->submissions()
            ->select('chapter', 'status', 'created_at', 'updated_at')
            ->orderBy('chapter')
            ->get()
            ->unique('chapter');

        // Get schedule timeline
        $schedules = $thesis->schedules()
            ->orderBy('defense_date')
            ->get();

        return view('mahasiswa.timeline', compact(
            'thesis',
            'submissions',
            'schedules'
        ));
    }

    /**
     * Mark feedback as resolved
     */
    public function resolveFeedback($feedbackId)
    {
        $user = Auth::user();
        $feedback = ThesisFeedback::with('submission.thesis')->findOrFail($feedbackId);

        // Check authorization
        if ($feedback->submission->thesis->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $feedback->update(['is_resolved' => true]);

        return redirect()->back()->with('success', 'Feedback marked as resolved');
    }

    /**
     * Download chapter file
     */
    public function downloadChapter($submissionId)
    {
        $user = Auth::user();
        $submission = ThesisSubmission::findOrFail($submissionId);

        // Check authorization
        if (
            $submission->user_id !== $user->id && $user->id !== $submission->thesis->advisor_id
            && $user->id !== $submission->thesis->co_advisor_id
        ) {
            abort(403, 'Unauthorized');
        }

        return response()->download(
            storage_path('app/private/' . $submission->file_path),
            $submission->file_name
        );
    }
}
