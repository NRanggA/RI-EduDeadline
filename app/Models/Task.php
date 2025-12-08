<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'deadline',
        'priority',
        'attachment_path',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the course that owns the task
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created the task (lecturer)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the task completions for this task
     */
    public function completions(): HasMany
    {
        return $this->hasMany(TaskCompletion::class);
    }

    /**
     * Get users who completed this task
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_completions')
            ->withPivot('status', 'completed_at', 'submission_notes', 'submission_file')
            ->withTimestamps();
    }

    /**
     * Scope: Get urgent tasks
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    /**
     * Scope: Get pending tasks
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get completed tasks
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Get tasks before a certain date
     */
    public function scopeBeforeDeadline($query, $date)
    {
        return $query->where('deadline', '<', $date);
    }

    /**
     * Scope: Get upcoming tasks (not yet overdue)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('deadline', '>=', now())
            ->where('status', '!=', 'completed');
    }

    /**
     * Get days remaining until deadline
     */
    public function getDaysRemainingAttribute(): int
    {
        return (int) now()->diffInDays($this->deadline, false);
    }

    /**
     * Check if task is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline < now() && $this->status !== 'completed';
    }
}
