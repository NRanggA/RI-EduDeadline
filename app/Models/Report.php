<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecturer_id',
        'course_id',
        'period_start',
        'period_end',
        'total_tasks',
        'completed_on_time',
        'completed_late',
        'not_submitted',
        'accuracy_rate',
        'notes',
    ];

    protected $casts = [
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the lecturer who owns this report
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Get the course for this report
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Calculate accuracy rate percentage
     */
    public function getAccuracyRateAttribute()
    {
        if ($this->total_tasks == 0) {
            return 0;
        }

        return round(($this->completed_on_time / $this->total_tasks) * 100, 2);
    }
}
