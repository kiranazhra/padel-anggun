<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'court_slug',
        'court_nama',
        'coach_id',
        'coach_nama',
        'coach_fee',
        'lokasi',
        'nama_pemesan',
        'tanggal',
        'waktu',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    /**
     * Sesi di jadwal pelatih yang otomatis dibuat dari reservasi ini
     * (kalau member memilih pelatih saat booking).
     */
    public function coachSession(): HasOne
    {
        return $this->hasOne(CoachSession::class);
    }

    public function isMenungguKonfirmasi(): bool
    {
        return $this->status === 'menunggu_konfirmasi';
    }

    public function isTerkonfirmasi(): bool
    {
        return $this->status === 'terkonfirmasi';
    }
}
