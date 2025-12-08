<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'date',
        'start_time',
        'end_time',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if this activity conflicts with another activity on the same day
     */
    public function hasConflict(): bool
    {
        $conflictingActivities = Activity::where('user_id', $this->user_id)
            ->where('date', $this->date)
            ->where('id', '!=', $this->id ?? 0)
            ->get();

        foreach ($conflictingActivities as $activity) {
            if ($this->timeOverlaps($activity)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get conflicting activities
     */
    public function getConflicts()
    {
        return Activity::where('user_id', $this->user_id)
            ->where('date', $this->date)
            ->where('id', '!=', $this->id ?? 0)
            ->get()
            ->filter(fn($activity) => $this->timeOverlaps($activity));
    }

    /**
     * Check if time overlaps with another activity
     */
    private function timeOverlaps(Activity $other): bool
    {
        $start1 = strtotime($this->start_time);
        $end1 = strtotime($this->end_time);
        $start2 = strtotime($other->start_time);
        $end2 = strtotime($other->end_time);

        return $start1 < $end2 && $start2 < $end1;
    }
}
