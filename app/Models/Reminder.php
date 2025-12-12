<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'title',
        'message',
        'recipient_type', // 'all_students', 'not_submitted', 'overdue'
        'scheduled_at',
        'sent_at',
        'is_sent',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the course associated with this reminder
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lecturer who created this reminder
     */
    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    /**
     * Get the students who received this reminder
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reminder_recipients', 'reminder_id', 'user_id')
            ->where('role', 'mahasiswa')
            ->withTimestamps();
    }
}
