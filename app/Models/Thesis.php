<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thesis extends Model
{
    use HasFactory;

    protected $table = 'thesis';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'advisor_id',
        'co_advisor_id',
        'defense_deadline',
        'status',
    ];

    protected $casts = [
        'defense_deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student who owns this thesis
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the advisor (pembimbing utama)
     */
    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    /**
     * Get the co-advisor (pembimbing kedua)
     */
    public function coAdvisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'co_advisor_id');
    }

    /**
     * Get all submissions for this thesis
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(ThesisSubmission::class);
    }

    /**
     * Get all schedules for this thesis
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(ThesisSchedule::class);
    }

    /**
     * Get the latest approved submission for each chapter
     */
    public function getLatestChapterSubmissions()
    {
        return $this->submissions()
            ->orderBy('chapter')
            ->get()
            ->unique('chapter')
            ->map(function ($submission) {
                return $submission->where('chapter', $submission->chapter)
                    ->orderBy('version', 'desc')
                    ->first();
            });
    }
}
