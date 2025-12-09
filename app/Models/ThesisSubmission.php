<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThesisSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_id',
        'user_id',
        'chapter',
        'title',
        'description',
        'file_path',
        'status',
        'version',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the thesis that owns this submission
     */
    public function thesis(): BelongsTo
    {
        return $this->belongsTo(Thesis::class);
    }

    /**
     * Get the student who submitted this
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all feedback for this submission
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(ThesisFeedback::class);
    }
}
