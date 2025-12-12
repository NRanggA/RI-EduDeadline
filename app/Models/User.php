<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;
use App\Models\Course;
use App\Models\Activity;
use App\Models\Reminder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nim',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships (untuk nanti)
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function courses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->withTimestamps();
    }

    public function taskCompletions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskCompletion::class);
    }

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function thesis(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Thesis::class, 'user_id');
    }

    public function advisedTheses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Thesis::class, 'advisor_id');
    }

    public function coAdvisedTheses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Thesis::class, 'co_advisor_id');
    }

    // Reminder relationships
    public function sentReminders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reminder::class, 'lecturer_id');
    }

    public function receivedReminders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Reminder::class, 'reminder_recipients', 'user_id', 'reminder_id')
            ->withTimestamps();
    }
}
