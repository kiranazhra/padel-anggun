<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'fee',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'fee' => 'integer',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(CoachSession::class);
    }

    /**
     * Reservasi lapangan yang memilih pelatih ini. Dipakai untuk mencegah
     * penghapusan pelatih yang masih punya reservasi aktif (lihat
     * Admin\CoachController::destroy) — supaya coach_id di reservasi tidak
     * ikut ter-NULL-kan dan sesinya di Jadwal Pelatih tidak "hilang jejak".
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Dipakai saat member memilih pelatih di form reservasi lapangan:
     * cek apakah pelatih ini bebas dari sesi lain (privat/akademi/istirahat)
     * yang bentrok pada tanggal dan jam mulai yang diminta.
     *
     * Durasi reservasi diasumsikan 2 jam untuk keperluan pengecekan bentrok,
     * mengikuti granularitas jadwal pelatih di panel admin.
     */
    public function isAvailableAt(string $date, string $startTime): bool
    {
        $startHour = (int) substr($startTime, 0, 2);
        $endTime = sprintf('%02d:00', min($startHour + 2, 23));

        return ! $this->sessions()
            ->whereDate('session_date', $date)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', sprintf('%02d:00', $startHour))
            ->exists();
    }
}
