<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $reservasiMenunggu = Reservation::where('status', 'menunggu_konfirmasi')->latest()->get();
        $totalPendapatan = Reservation::where('status', 'terkonfirmasi')->sum('total_harga');
        $totalAnggota = User::count();
        $totalReservasi = Reservation::count();

        // Prefer persisted activity logs when available
        if (ActivityLog::count() > 0) {
            $aktivitas = ActivityLog::latest()->take(6)->get()->map(fn (ActivityLog $a) => [
                'icon' => match($a->type) {
                    'registration' => 'person_add',
                    'booking' => 'sports_tennis',
                    'confirmed' => 'payments',
                    'cancelled' => 'event_busy',
                    default => 'info',
                },
                'iconBg' => 'bg-secondary-container',
                'iconColor' => 'text-on-secondary-container',
                'text' => $a->text,
                'time' => $a->created_at,
                'type' => $a->type,
            ]);
            $unread = ActivityLog::whereNull('read_at')->count();
        } else {
            $aktivitas = $this->recentActivity();
            $unread = 0;
        }

        return view('admin.dashboard', compact(
            'reservasiMenunggu', 'totalPendapatan', 'totalAnggota', 'totalReservasi', 'aktivitas'
        ))->with('unreadNotifications', $unread);
    }

    /**
     * Show a full activity feed built from database events.
     */
    public function activities(Request $request): View
    {
        // If activity logs exist, query them for paginable results
        if (ActivityLog::count() > 0) {
            $query = ActivityLog::query();
            $type = $request->query('type', 'all');
            $q = $request->query('q');
            $start = $request->query('start_date');
            $end = $request->query('end_date');

            if ($type && $type !== 'all') {
                $query->where('type', $type);
            }
            if ($q) {
                $query->where('text', 'like', "%{$q}%");
            }
            if ($start) {
                $query->whereDate('created_at', '>=', $start);
            }
            if ($end) {
                $query->whereDate('created_at', '<=', $end);
            }

            $logs = $query->latest('created_at')->paginate(20)->withQueryString();

            $aktivitas = $logs->getCollection()->map(fn (ActivityLog $a) => [
                'icon' => match($a->type) {
                    'registration' => 'person_add',
                    'booking' => 'sports_tennis',
                    'confirmed' => 'payments',
                    'cancelled' => 'event_busy',
                    default => 'info',
                },
                'iconBg' => 'bg-secondary-container',
                'iconColor' => 'text-on-secondary-container',
                'text' => $a->text,
                'time' => $a->created_at,
                'type' => $a->type,
            ]);

            return view('admin.activities', ['aktivitas' => $aktivitas, 'filter' => [
                'type' => $type, 'q' => $q, 'start' => $start, 'end' => $end,
            ], 'logs' => $logs]);
        }
        $type = $request->query('type', 'all');
        $q = $request->query('q');
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        $registrations = User::latest()->get()->map(fn (User $user) => [
            'icon' => 'person_add',
            'iconBg' => 'bg-tertiary-container',
            'iconColor' => 'text-on-tertiary-container',
            'text' => "<span class=\"font-semibold\">{$user->name}</span> mendaftar sebagai anggota baru",
            'time' => $user->created_at,
            'type' => 'registration',
        ]);

        $bookings = Reservation::latest()->get()->map(fn (Reservation $r) => [
            'icon' => 'sports_tennis',
            'iconBg' => 'bg-secondary-container',
            'iconColor' => 'text-on-secondary-container',
            'text' => '<span class="font-semibold">' . ($r->nama_pemesan ?: 'Tamu') . "</span> mem-booking {$r->court_nama}",
            'time' => $r->created_at,
            'type' => 'booking',
        ]);

        $confirmed = Reservation::where('status', 'terkonfirmasi')
            ->latest('updated_at')->get()
            ->map(fn (Reservation $r) => [
                'icon' => 'payments',
                'iconBg' => 'bg-primary-container',
                'iconColor' => 'text-on-primary-container',
                'text' => 'Pembayaran <span class="font-semibold">Rp ' . number_format($r->total_harga, 0, ',', '.')
                    . "</span> dikonfirmasi untuk {$r->court_nama}",
                'time' => $r->updated_at,
                'type' => 'confirmed',
            ]);

        $cancelled = Reservation::where('status', 'dibatalkan')
            ->latest('updated_at')->get()
            ->map(fn (Reservation $r) => [
                'icon' => 'event_busy',
                'iconBg' => 'bg-surface-variant',
                'iconColor' => 'text-on-surface-variant',
                'text' => '<span class="font-semibold">' . ($r->nama_pemesan ?: 'Tamu') . "</span> membatalkan booking {$r->court_nama}",
                'time' => $r->updated_at,
                'type' => 'cancelled',
            ]);

        $aktivitas = $registrations
            ->concat($bookings)
            ->concat($confirmed)
            ->concat($cancelled)
            ->sortByDesc('time')
            ->values();

        // Filter by type
        if ($type && $type !== 'all') {
            $aktivitas = $aktivitas->where('type', $type)->values();
        }

        // Search in text
        if ($q) {
            $aktivitas = $aktivitas->filter(fn ($it) => stripos($it['text'], $q) !== false)->values();
        }

        // Date range filters
        if ($start) {
            $startDate = Carbon::parse($start)->startOfDay();
            $aktivitas = $aktivitas->filter(fn ($it) => $it['time']->gte($startDate))->values();
        }

        if ($end) {
            $endDate = Carbon::parse($end)->endOfDay();
            $aktivitas = $aktivitas->filter(fn ($it) => $it['time']->lte($endDate))->values();
        }

        return view('admin.activities', [
            'aktivitas' => $aktivitas,
            'filter' => ['type' => $type, 'q' => $q, 'start' => $start, 'end' => $end],
        ]);
    }

    /**
     * Mark all unread activity logs as read.
     */
    public function markRead(Request $request)
    {
        ActivityLog::whereNull('read_at')->update(['read_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }

    /**
     * Build a live "recent activity" feed straight from real timestamps —
     * new members, new bookings, confirmations, and cancellations — instead
     * of a hardcoded list. No separate activity-log table needed.
     */
    private function recentActivity(int $limit = 6)
    {
        $registrations = User::latest()->take($limit)->get()->map(fn (User $user) => [
            'icon' => 'person_add',
            'iconBg' => 'bg-tertiary-container',
            'iconColor' => 'text-on-tertiary-container',
            'text' => "<span class=\"font-semibold\">{$user->name}</span> mendaftar sebagai anggota baru",
            'time' => $user->created_at,
        ]);

        $bookings = Reservation::latest()->take($limit)->get()->map(fn (Reservation $r) => [
            'icon' => 'sports_tennis',
            'iconBg' => 'bg-secondary-container',
            'iconColor' => 'text-on-secondary-container',
            'text' => '<span class="font-semibold">' . ($r->nama_pemesan ?: 'Tamu') . "</span> mem-booking {$r->court_nama}",
            'time' => $r->created_at,
        ]);

        $confirmed = Reservation::where('status', 'terkonfirmasi')
            ->latest('updated_at')->take($limit)->get()
            ->map(fn (Reservation $r) => [
                'icon' => 'payments',
                'iconBg' => 'bg-primary-container',
                'iconColor' => 'text-on-primary-container',
                'text' => 'Pembayaran <span class="font-semibold">Rp ' . number_format($r->total_harga, 0, ',', '.')
                    . "</span> dikonfirmasi untuk {$r->court_nama}",
                'time' => $r->updated_at,
            ]);

        $cancelled = Reservation::where('status', 'dibatalkan')
            ->latest('updated_at')->take($limit)->get()
            ->map(fn (Reservation $r) => [
                'icon' => 'event_busy',
                'iconBg' => 'bg-surface-variant',
                'iconColor' => 'text-on-surface-variant',
                'text' => '<span class="font-semibold">' . ($r->nama_pemesan ?: 'Tamu') . "</span> membatalkan booking {$r->court_nama}",
                'time' => $r->updated_at,
            ]);

        return $registrations
            ->concat($bookings)
            ->concat($confirmed)
            ->concat($cancelled)
            ->sortByDesc('time')
            ->take($limit)
            ->values();
    }
}
