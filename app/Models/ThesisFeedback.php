<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThesisFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_submission_id',
        'advisor_id',
        'feedback',
        'type',
        'line_number',
        'priority',
        'is_resolved',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the submission that this feedback is for
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(ThesisSubmission::class, 'thesis_submission_id');
    }

    /**
     * Get the advisor who provided this feedback
     */
    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
}
