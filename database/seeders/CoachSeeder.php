<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\CoachSession;
use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
{
    public function run(): void
    {
        $adrian = Coach::firstOrCreate(['name' => 'Coach Adrian'], ['specialty' => 'Sesi Privat & Akademi', 'fee' => 200000]);
        $maya = Coach::firstOrCreate(['name' => 'Coach Maya'], ['specialty' => 'Akademi Pemula', 'fee' => 150000]);
        $rio = Coach::firstOrCreate(['name' => 'Coach Rio'], ['specialty' => 'Sesi Privat', 'fee' => 175000]);

        $today = now()->toDateString();

        // Hanya isi contoh jadwal kalau belum ada apa-apa untuk hari ini,
        // supaya seeder aman dijalankan berulang kali.
        if (CoachSession::whereDate('session_date', $today)->exists()) {
            return;
        }

        CoachSession::create([
            'coach_id' => $adrian->id,
            'type' => 'privat',
            'title' => 'Privat: Bpk. Haryo',
            'session_date' => $today,
            'start_time' => '08:00',
            'end_time' => '10:00',
            'location' => 'Lapangan 1',
        ]);

        CoachSession::create([
            'coach_id' => $maya->id,
            'type' => 'akademi',
            'title' => 'Akademi Pemula',
            'session_date' => $today,
            'start_time' => '09:00',
            'end_time' => '11:00',
            'notes' => '4 Peserta',
        ]);

        CoachSession::create([
            'coach_id' => $adrian->id,
            'type' => 'istirahat',
            'title' => 'Istirahat',
            'session_date' => $today,
            'start_time' => '10:00',
            'end_time' => '11:00',
        ]);

        CoachSession::create([
            'coach_id' => $rio->id,
            'type' => 'privat',
            'title' => 'Privat: Ibu Sarah',
            'session_date' => $today,
            'start_time' => '10:00',
            'end_time' => '12:00',
            'location' => 'Lapangan 3',
        ]);
    }
}
