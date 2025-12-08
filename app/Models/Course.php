<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'icon',
        'lecturer_id',
        'description',
        'semester',
        'credits',
    ];

    /**
     * Get the lecturer (dosen) who owns this course
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Get all tasks for this course
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get all students enrolled in this course
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->where('role', 'mahasiswa')
            ->withTimestamps();
    }

    /**
     * Calculate progress of a specific student in this course
     * Progress = (completed/submitted tasks / total tasks) * 100
     */
    public function getStudentProgress($userId): float
    {
        $totalTasks = $this->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        // Count tasks yang sudah submitted atau approved
        $completedTasks = $this->tasks()
            ->whereHas('completions', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->whereIn('status', ['submitted', 'approved']);
            })
            ->count();

        return round(($completedTasks / $totalTasks) * 100, 2);
    }

    /**
     * Get active tasks (not completed, deadline not passed)
     */
    public function getActiveTasks()
    {
        return $this->tasks()
            ->where('status', '!=', 'completed')
            ->where('deadline', '>=', now())
            ->get();
    }
}
