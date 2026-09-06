<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use App\Models\CoachSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReservationController extends Controller
{
    public function create()
    {
        return view('admin.create-reservation', [
            'users' => User::orderBy('name')->get(),
            'courts' => Court::where('is_active', true)->where('status', 'tersedia')->orderBy('nama')->get(),
            'coaches' => Coach::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'court_id' => 'required|exists:courts,id',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:20',
            'coach_id' => 'nullable|exists:coaches,id',
        ]);

        $user = User::find($validated['user_id']);
        $court = Court::find($validated['court_id']);
        $coach = $validated['coach_id'] ? Coach::find($validated['coach_id']) : null;

        $surcharge = 50000;
        $coachFee = $coach?->fee ?? 0;

        DB::transaction(function () use ($user, $court, $coach, $validated, $surcharge, $coachFee) {
            $reservation = Reservation::create([
                'user_id' => $user->id,
                'court_slug' => $court->slug,
                'court_nama' => $court->nama,
                'coach_id' => $coach?->id,
                'coach_nama' => $coach?->name,
                'coach_fee' => $coachFee,
                'lokasi' => $court->lokasi ?? null,
                'nama_pemesan' => $user->name,
                'tanggal' => $validated['tanggal'],
                'waktu' => $validated['waktu'],
                'total_harga' => ($court->harga ?? 0) + $surcharge + $coachFee,
                'status' => 'terkonfirmasi',
            ]);

            if ($coach) {
                $startHour = (int) substr($validated['waktu'], 0, 2);

                CoachSession::create([
                    'coach_id' => $coach->id,
                    'reservation_id' => $reservation->id,
                    'type' => 'privat',
                    'title' => 'Privat: ' . $user->name,
                    'session_date' => $validated['tanggal'],
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', min($startHour + 2, 23)),
                    'location' => $court->nama,
                    'notes' => 'Booking oleh admin',
                ]);
            }
        });

        return redirect()->route('admin.dashboard')->with('status', 'Reservasi berhasil dibuat.');
    }
}
