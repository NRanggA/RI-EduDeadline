<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskCompletion extends Model
{
    use HasFactory;

    protected $table = 'task_completions';

    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'completed_at',
        'submission_notes',
        'submission_file',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the task associated with this completion
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who submitted this task
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
