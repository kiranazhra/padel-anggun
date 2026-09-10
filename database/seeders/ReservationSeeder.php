<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Isi reservasi dummy yang tersebar di minggu ini & minggu lalu, supaya
     * chart "Tren Pendapatan Mingguan" di dashboard admin (dan filter
     * tanggalnya) langsung ada datanya untuk dites, tanpa perlu booking
     * manual lewat aplikasi berkali-kali.
     */
    public function run(): void
    {
        // Aman dijalankan berulang: kalau sudah pernah di-seed, lewati saja.
        if (Reservation::count() > 0) {
            return;
        }

        $user = User::where('email', 'test@example.com')->first();
        $adrian = Coach::where('name', 'Coach Adrian')->first();
        $maya = Coach::where('name', 'Coach Maya')->first();

        $courts = [
            'mawar' => ['nama' => 'Lapangan Mawar', 'lokasi' => 'Area Timur (Outdoor)', 'harga' => 350000],
            'melati' => ['nama' => 'Lapangan Melati', 'lokasi' => 'Area Barat (Indoor)', 'harga' => 450000],
            'dahlia' => ['nama' => 'Lapangan Dahlia', 'lokasi' => 'Area Utara (Outdoor)', 'harga' => 300000],
        ];

        $awalMingguIni = now()->startOfWeek();
        $awalMingguLalu = now()->subWeek()->startOfWeek();

        // Minggu ini: beberapa reservasi terkonfirmasi tersebar di hari
        // berbeda + 1 masih menunggu konfirmasi (biar tabel "Reservasi
        // Menunggu Konfirmasi" di admin juga ada isinya).
        $this->buatReservasi($user, $courts['mawar'], 'mawar', $awalMingguIni->copy()->addDays(0), '08:00', 'terkonfirmasi', $adrian);
        $this->buatReservasi($user, $courts['melati'], 'melati', $awalMingguIni->copy()->addDays(1), '19:00', 'terkonfirmasi', null);
        $this->buatReservasi($user, $courts['dahlia'], 'dahlia', $awalMingguIni->copy()->addDays(2), '16:00', 'terkonfirmasi', $maya);
        $this->buatReservasi($user, $courts['mawar'], 'mawar', $awalMingguIni->copy()->addDays(3), '17:00', 'terkonfirmasi', null);
        $this->buatReservasi($user, $courts['melati'], 'melati', $awalMingguIni->copy()->addDays(4), '13:00', 'dibatalkan', null);
        $this->buatReservasi($user, $courts['dahlia'], 'dahlia', $awalMingguIni->copy()->addDays(5), '11:00', 'terkonfirmasi', null);
        $this->buatReservasi($user, $courts['mawar'], 'mawar', now()->addDay(), '10:00', 'menunggu_konfirmasi', null);

        // Minggu lalu: beberapa reservasi terkonfirmasi, supaya filter
        // tanggal di chart bisa dites pindah minggu.
        $this->buatReservasi($user, $courts['melati'], 'melati', $awalMingguLalu->copy()->addDays(0), '08:00', 'terkonfirmasi', null);
        $this->buatReservasi($user, $courts['dahlia'], 'dahlia', $awalMingguLalu->copy()->addDays(2), '14:00', 'terkonfirmasi', $adrian);
        $this->buatReservasi($user, $courts['mawar'], 'mawar', $awalMingguLalu->copy()->addDays(4), '15:00', 'terkonfirmasi', null);
        $this->buatReservasi($user, $courts['melati'], 'melati', $awalMingguLalu->copy()->addDays(6), '19:00', 'terkonfirmasi', null);
    }

    private function buatReservasi(?User $user, array $court, string $slug, \Illuminate\Support\Carbon $tanggal, string $waktu, string $status, ?Coach $coach): void
    {
        $surcharge = 50000;
        $coachFee = $coach?->fee ?? 0;

        Reservation::create([
            'user_id' => $user?->id,
            'court_slug' => $slug,
            'court_nama' => $court['nama'],
            'coach_id' => $coach?->id,
            'coach_nama' => $coach?->name,
            'coach_fee' => $coachFee,
            'lokasi' => $court['lokasi'],
            'nama_pemesan' => $user?->name ?? 'Tamu',
            'tanggal' => $tanggal->toDateString(),
            'waktu' => $waktu,
            'total_harga' => $court['harga'] + $surcharge + $coachFee,
            'status' => $status,
        ]);
    }
}
