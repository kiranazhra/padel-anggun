<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoachSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'reservation_id',
        'type',
        'title',
        'session_date',
        'start_time',
        'end_time',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
        ];
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Duration in whole hours, used to size the slot on the schedule grid.
     */
    public function durationHours(): int
    {
        return max(1, (int) substr($this->end_time, 0, 2) - (int) substr($this->start_time, 0, 2));
    }

    public function startHour(): int
    {
        return (int) substr($this->start_time, 0, 2);
    }
}
