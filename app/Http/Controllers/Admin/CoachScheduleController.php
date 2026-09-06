<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\CoachSession;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CoachScheduleController extends Controller
{
    /**
     * Jam operasional yang ditampilkan di grid (jam mulai per baris).
     */
    private const START_HOUR = 8;

    private const END_HOUR = 21; // baris terakhir dimulai jam 21:00

    public function index(Request $request): View
    {
        $date = $this->resolveDate($request->query('date'));

        $coaches = Coach::where('is_active', true)->orderBy('id')->get();

        // Semua pelatih (termasuk nonaktif) untuk panel "Kelola Pelatih".
        $allCoaches = Coach::orderBy('id')->get();

        $sessions = CoachSession::with('coach')
            ->whereDate('session_date', $date->toDateString())
            ->orderBy('start_time')
            ->get();

        $hours = range(self::START_HOUR, self::END_HOUR);

        // $grid[hour][coach_id] = CoachSession yang dimulai di jam itu (atau null).
        // $covered[coach_id][hour] = true kalau jam itu "ditutupi" oleh sesi yang
        // mulai di jam sebelumnya (supaya tidak dirender dua kali).
        $grid = [];
        $covered = [];

        foreach ($hours as $hour) {
            foreach ($coaches as $coach) {
                $grid[$hour][$coach->id] = null;
            }
        }

        foreach ($sessions as $session) {
            $startHour = $session->startHour();
            $span = min($session->durationHours(), 3); // grid cuma dukung tinggi 1-3 baris

            // PENTING: pakai array_key_exists(), BUKAN isset() — karena nilai
            // default di $grid adalah null, dan isset() menganggap null itu
            // "tidak diset" walau key-nya sebenarnya ada. Kalau pakai isset(),
            // baris ini SELALU meng-skip setiap sesi tanpa terkecuali.
            if (! array_key_exists($startHour, $grid) || ! array_key_exists($session->coach_id, $grid[$startHour])) {
                continue; // di luar jam operasional yang ditampilkan, atau pelatihnya nonaktif
            }

            $grid[$startHour][$session->coach_id] = $session;

            for ($h = $startHour + 1; $h < $startHour + $span; $h++) {
                $covered[$session->coach_id][$h] = true;
            }
        }

        return view('admin.jadwal-pelatih', [
            'coaches' => $coaches,
            'allCoaches' => $allCoaches,
            'hours' => $hours,
            'grid' => $grid,
            'covered' => $covered,
            'date' => $date,
            'sessions' => $sessions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $date = $this->resolveDate($request->input('session_date'));

        $validated = $request->validate([
            'coach_id' => ['required', 'exists:coaches,id'],
            'type' => ['required', Rule::in(['privat', 'akademi', 'istirahat'])],
            'title' => ['required', 'string', 'max:100'],
            'start_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer', 'min:1', 'max:3'],
            'location' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:100'],
        ]);

        $startHour = (int) substr($validated['start_time'], 0, 2);
        $endHour = $startHour + (int) $validated['duration'];

        if ($startHour < self::START_HOUR || $endHour > self::END_HOUR + 1) {
            return back()
                ->withInput()
                ->with('status', 'Jam sesi harus berada dalam jam operasional (08:00 - 21:00).');
        }

        $endTime = sprintf('%02d:00', $endHour);

        $overlap = CoachSession::where('coach_id', $validated['coach_id'])
            ->whereDate('session_date', $date->toDateString())
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $validated['start_time'])
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->with('status', 'Pelatih ini sudah punya sesi lain yang bentrok di jam tersebut.');
        }

        CoachSession::create([
            'coach_id' => $validated['coach_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'session_date' => $date->toDateString(),
            'start_time' => $validated['start_time'],
            'end_time' => $endTime,
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.jadwal-pelatih', ['date' => $date->toDateString()])
            ->with('status', 'Sesi "' . $validated['title'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, CoachSession $coachSession): RedirectResponse
    {
        $date = $this->resolveDate($request->input('session_date')) ?: $coachSession->session_date;

        $validated = $request->validate([
            'coach_id' => ['required', 'exists:coaches,id'],
            'type' => ['required', Rule::in(['privat', 'akademi', 'istirahat'])],
            'title' => ['required', 'string', 'max:100'],
            'start_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer', 'min:1', 'max:3'],
            'location' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:100'],
        ]);

        $startHour = (int) substr($validated['start_time'], 0, 2);
        $endHour = $startHour + (int) $validated['duration'];

        if ($startHour < self::START_HOUR || $endHour > self::END_HOUR + 1) {
            return back()
                ->withInput()
                ->with('status', 'Jam sesi harus berada dalam jam operasional (08:00 - 21:00).');
        }

        $endTime = sprintf('%02d:00', $endHour);

        $overlap = CoachSession::where('coach_id', $validated['coach_id'])
            ->where('id', '!=', $coachSession->id)
            ->whereDate('session_date', $date->toDateString())
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $validated['start_time'])
            ->exists();

        if ($overlap) {
            return back()
                ->withInput()
                ->with('status', 'Pelatih ini sudah punya sesi lain yang bentrok di jam tersebut.');
        }

        $coachSession->update([
            'coach_id' => $validated['coach_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'session_date' => $date->toDateString(),
            'start_time' => $validated['start_time'],
            'end_time' => $endTime,
            'location' => $validated['location'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.jadwal-pelatih', ['date' => $date->toDateString()])
            ->with('status', 'Sesi "' . $validated['title'] . '" berhasil diperbarui.');
    }

    public function destroy(Request $request, CoachSession $coachSession): RedirectResponse
    {
        $date = $coachSession->session_date->toDateString();
        $title = $coachSession->title;
        $coachSession->delete();

        return redirect()
            ->route('admin.jadwal-pelatih', ['date' => $date])
            ->with('status', 'Sesi "' . $title . '" telah dihapus.');
    }

    /**
     * Backfill manual: buat sesi untuk reservasi lama yang sudah punya
     * pelatih tapi belum tersinkron ke Jadwal Pelatih (mis. dibuat sebelum
     * fitur sinkronisasi otomatis ini ada). Dipicu dari tombol "Sinkronkan
     * dari Reservasi" di halaman ini.
     */
    public function syncFromReservations(): RedirectResponse
    {
        $jumlah = \App\Http\Controllers\ReservationController::syncMissingCoachSessions();

        return back()->with(
            'status',
            $jumlah > 0
                ? "{$jumlah} sesi pelatih berhasil disinkronkan dari reservasi yang belum tercatat."
                : 'Semua reservasi yang punya pelatih sudah tersinkron, tidak ada yang perlu diperbarui.'
        );
    }

    private function resolveDate(?string $raw): Carbon
    {
        try {
            return $raw ? Carbon::parse($raw)->startOfDay() : Carbon::today();
        } catch (\Exception) {
            return Carbon::today();
        }
    }
}
