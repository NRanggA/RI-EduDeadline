<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThesisSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_id',
        'defense_date',
        'defense_time',
        'location',
        'room',
        'examiner_1_id',
        'examiner_2_id',
        'notes',
        'status',
    ];

    protected $casts = [
        'defense_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the thesis that owns this schedule
     */
    public function thesis(): BelongsTo
    {
        return $this->belongsTo(Thesis::class);
    }

    /**
     * Get the first examiner
     */
    public function examiner1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'examiner_1_id');
    }

    /**
     * Get the second examiner
     */
    public function examiner2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'examiner_2_id');
    }
}
