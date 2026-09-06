<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends Model
{
    protected $fillable = [
        'slug',
        'nama',
        'lokasi',
        'tipe',
        'harga',
        'harga_coret',
        'deskripsi',
        'gambar_utama',
        'slot',
        'status',
        'status_catatan',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'slot' => 'array',
            'harga' => 'integer',
            'harga_coret' => 'integer',
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'court_slug', 'slug');
    }

    /**
     * Reservasi yang sedang berlangsung "sekarang" di lapangan ini (kalau
     * ada) — dipakai supaya status "Digunakan" di panel admin otomatis
     * mengikuti data reservasi asli, bukan status yang harus diset manual.
     * Sesi reservasi berdurasi 2 jam sejak waktu mulainya (sama seperti
     * aturan yang dipakai untuk membuat sesi di Jadwal Pelatih).
     */
    public function activeReservation(): ?Reservation
    {
        $now = now();

        return $this->reservations()
            ->where('status', 'terkonfirmasi')
            ->whereDate('tanggal', $now->toDateString())
            ->get()
            ->first(function (Reservation $reservation) use ($now) {
                $mulai = (int) substr($reservation->waktu, 0, 2);
                $selesai = min($mulai + 2, 24);

                return $now->hour >= $mulai && $now->hour < $selesai;
            });
    }

    /**
     * Label & warna badge status untuk ditampilkan di panel admin.
     *
     * Status "Digunakan" dihitung otomatis dari reservasi asli yang sedang
     * berlangsung saat ini (bukan disimpan manual) — begitu jam sesinya
     * lewat, status kembali sendiri ke "Tersedia" tanpa perlu disentuh
     * admin. Status "Pemeliharaan" tetap dikontrol manual oleh admin
     * karena tidak berkaitan dengan reservasi.
     *
     * @return array{label: string, badge: string, catatan: ?string, otomatis: bool}
     */
    public function statusMeta(): array
    {
        if ($reservasi = $this->activeReservation()) {
            $catatan = $reservasi->nama_pemesan . ($reservasi->coach_nama ? ' + Pelatih ' . $reservasi->coach_nama : '');

            return ['label' => 'Digunakan', 'badge' => 'bg-error-container text-on-error-container', 'catatan' => $catatan, 'otomatis' => true];
        }

        return match ($this->status) {
            'pemeliharaan' => ['label' => 'Pemeliharaan', 'badge' => 'bg-tertiary-container text-on-tertiary-container', 'catatan' => $this->status_catatan, 'otomatis' => false],
            default => ['label' => 'Tersedia', 'badge' => 'bg-secondary-container text-on-secondary-container', 'catatan' => $this->status_catatan, 'otomatis' => false],
        };
    }

    /**
     * Bentuk array yang dipakai halaman customer (/lapangan, /reservasi/{court}),
     * supaya kode di ReservationController tetap sama seperti sebelumnya waktu
     * datanya masih statis.
     *
     * @return array<string, mixed>
     */
    public function toCourtArray(): array
    {
        return [
            'id' => $this->slug,
            'nama' => $this->nama,
            'lokasi' => $this->lokasi,
            'tipe' => $this->tipe,
            'harga' => $this->harga,
            'harga_coret' => $this->harga_coret,
            'deskripsi' => $this->deskripsi,
            'gambar_utama' => $this->gambar_utama,
            'slot' => $this->slot ?? [],
            'slot_penuh' => [],
        ];
    }
}
