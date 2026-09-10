<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\CoachSession;
use App\Models\Court;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Halaman /lapangan — daftar lapangan dengan filter tanggal, waktu, dan
     * tipe yang beneran aktif. Ketersediaan slot dihitung dari reservasi
     * asli pada tanggal yang dipilih (bukan status "penuh" statis).
     */
    public function index(Request $request): View
    {
        $tanggal = $request->query('tanggal') ?: now()->toDateString();
        $waktu = $request->query('waktu') ?: 'semua';
        $tipe = $request->query('tipe') ?: 'semua';

        $rentangWaktu = [
            'pagi' => ['06:00', '12:00'],
            'sore' => ['15:00', '18:00'],
            'malam' => ['18:00', '22:00'],
        ];

        $courts = collect(self::courts())
            ->map(function (array $court) use ($tanggal) {
                // Slot yang sudah dipesan (dan belum dibatalkan) di tanggal ini —
                // dihitung dari data reservasi asli, bukan daftar statis.
                $court['slot_penuh'] = Reservation::where('court_slug', $court['id'])
                    ->whereDate('tanggal', $tanggal)
                    ->where('status', '!=', 'dibatalkan')
                    ->pluck('waktu')
                    ->all();

                return $court;
            })
            ->when($tipe !== 'semua', fn ($collection) => $collection->where('tipe', $tipe))
            ->when($waktu !== 'semua' && isset($rentangWaktu[$waktu]), function ($collection) use ($waktu, $rentangWaktu) {
                [$mulai, $selesai] = $rentangWaktu[$waktu];

                return $collection
                    ->map(function (array $court) use ($mulai, $selesai) {
                        $court['slot'] = array_values(array_filter(
                            $court['slot'],
                            fn (string $jam) => $jam >= $mulai && $jam < $selesai
                        ));

                        return $court;
                    })
                    ->filter(fn (array $court) => count($court['slot']) > 0);
            })
            ->values();

        return view('lapangan', [
            'courts' => $courts,
            'filters' => [
                'tanggal' => $tanggal,
                'waktu' => $waktu,
                'tipe' => $tipe,
            ],
        ]);
    }

    /**
     * Data lapangan yang aktif, diambil dari tabel "courts" yang dikelola
     * admin lewat panel Kelola Lapangan. Kuncinya dipakai sebagai slug di
     * URL: /lapangan dan /reservasi/{court}. Lapangan yang sedang
     * dinonaktifkan admin, atau berstatus "digunakan"/"pemeliharaan" (bukan
     * "tersedia"), tidak ikut tampil/tidak bisa dipesan di sini.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function courts(): array
    {
        return Court::where('is_active', true)
            ->where('status', 'tersedia')
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get()
            ->mapWithKeys(fn (Court $court) => [$court->slug => $court->toCourtArray()])
            ->all();
    }

    /**
     * Halaman /reservasi/{court} — form pilih tanggal & waktu untuk lapangan tertentu.
     */
    public function show(string $court): View
    {
        $courts = self::courts();
        abort_unless(isset($courts[$court]), 404);

        // 5 tanggal ke depan mulai hari ini, biar demonya selalu relevan.
        $dates = collect(range(0, 4))->map(function (int $i) {
            $date = Carbon::today()->addDays($i);
            return [
                'iso' => $date->toDateString(),
                'hari' => strtoupper($date->translatedFormat('D')),
                'tanggal' => $date->format('d'),
            ];
        });

        return view('detail-reservasi', [
            'court' => $courts[$court],
            'dates' => $dates,
            'coaches' => Coach::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Simpan reservasi baru berstatus "menunggu_konfirmasi", lalu arahkan ke dasbor.
     * Pelatih bersifat opsional; kalau dipilih, biayanya ditambahkan ke total
     * dan dicek dulu supaya tidak bentrok dengan jadwal pelatih yang lain.
     */
    public function store(Request $request, string $court): RedirectResponse
    {
        $courts = self::courts();
        abort_unless(isset($courts[$court]), 404);
        $data = $courts[$court];

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:20',
            'coach_id' => 'nullable|exists:coaches,id',
        ]);

        $coach = null;

        if (! empty($validated['coach_id'])) {
            $coach = Coach::where('is_active', true)->find($validated['coach_id']);

            if (! $coach) {
                return back()->withInput()->with('status', 'Pelatih yang dipilih tidak tersedia lagi.');
            }

            if (! $coach->isAvailableAt($validated['tanggal'], $validated['waktu'])) {
                return back()
                    ->withInput()
                    ->with('status', "{$coach->name} sudah memiliki sesi lain pada jam tersebut. Pilih pelatih lain atau jam yang berbeda.");
            }
        }

        $surcharge = 50000;
        $coachFee = $coach?->fee ?? 0;

        $reservation = DB::transaction(function () use ($request, $court, $data, $validated, $coach, $surcharge, $coachFee) {
            $reservation = Reservation::create([
                'user_id' => $request->user()->id,
                'court_slug' => $court,
                'court_nama' => $data['nama'],
                'coach_id' => $coach?->id,
                'coach_nama' => $coach?->name,
                'coach_fee' => $coachFee,
                'lokasi' => $data['lokasi'],
                'nama_pemesan' => $request->user()->name,
                'tanggal' => $validated['tanggal'],
                'waktu' => $validated['waktu'],
                'total_harga' => $data['harga'] + $surcharge + $coachFee,
                'status' => 'menunggu_konfirmasi',
            ]);

            // Sinkronkan otomatis ke Jadwal Pelatih (admin) supaya pelatih yang
            // dipilih langsung "terisi" di grid jadwal, dan tidak bisa
            // dobel-booking lewat form tambah sesi manual admin. Dibungkus
            // transaksi bersama reservasi: kalau ini gagal, reservasi ikut
            // dibatalkan supaya tidak ada data yang setengah-jadi.
            if ($coach) {
                $startHour = (int) substr($validated['waktu'], 0, 2);

                CoachSession::create([
                    'coach_id' => $coach->id,
                    'reservation_id' => $reservation->id,
                    'type' => 'privat',
                    'title' => 'Privat: ' . $request->user()->name,
                    'session_date' => $validated['tanggal'],
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', min($startHour + 2, 23)),
                    'location' => $data['nama'],
                    'notes' => 'Booking Lapangan',
                ]);
            }

            return $reservation;
        });

        $pesan = 'Reservasi ' . $data['nama'] . ($coach ? " bersama {$coach->name}" : '') . ' berhasil dibuat dan sedang menunggu konfirmasi admin.';

        return redirect()
            ->route('dashboard')
            ->with('status', $pesan);
    }

    /**
     * Batalkan reservasi milik sendiri dari tombol "Kelola" di dasbor
     * customer. Hanya pemilik reservasi yang boleh membatalkan; reservasi
     * yang sudah dibatalkan tidak bisa dibatalkan lagi.
     */
    public function cancel(Request $request, Reservation $reservation): RedirectResponse
    {
        abort_unless($reservation->user_id === $request->user()->id, 403);

        if ($reservation->status === 'dibatalkan') {
            return redirect()->route('dashboard')->with('status', 'Reservasi ini sudah dibatalkan sebelumnya.');
        }

        $reservation->update(['status' => 'dibatalkan']);

        // Bebaskan slot pelatih yang otomatis ter-booking dari reservasi ini,
        // sama seperti saat admin menolak reservasi (route admin.reservasi.tolak).
        $reservation->coachSession?->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Reservasi ' . $reservation->court_nama . ' telah dibatalkan.');
    }

    /**
     * Backfill: buat sesi di Jadwal Pelatih untuk reservasi lama yang sudah
     * punya pelatih tapi belum tersinkron (misalnya dibuat sebelum fitur ini
     * ada, atau sempat gagal karena migration belum jalan). Dipanggil dari
     * tombol "Sinkronkan dari Reservasi" di halaman admin Jadwal Pelatih.
     *
     * Juga mencoba mencocokkan ulang reservasi yang coach_id-nya sudah
     * ter-NULL-kan (karena pelatih aslinya sempat dihapus) tapi nama
     * pelatihnya (coach_nama, snapshot) cocok persis dengan pelatih aktif
     * saat ini — misalnya kalau pelatih yang sama sempat dihapus lalu
     * ditambahkan lagi dengan nama yang sama.
     */
    public static function syncMissingCoachSessions(): int
    {
        $dibuat = 0;

        // Kasus normal: coach_id masih ada, tinggal buatkan sesinya.
        $reservations = Reservation::query()
            ->whereNotNull('coach_id')
            ->where('status', '!=', 'dibatalkan')
            ->whereDoesntHave('coachSession')
            ->get();

        foreach ($reservations as $reservation) {
            self::buatSesiDariReservasi($reservation, $reservation->coach_id);
            $dibuat++;
        }

        // Kasus pelatih aslinya sudah terhapus (coach_id ter-NULL-kan):
        // coba cocokkan lewat nama pelatih yang tersimpan (coach_nama) ke
        // pelatih aktif saat ini dengan nama yang sama persis.
        $orphan = Reservation::query()
            ->whereNull('coach_id')
            ->whereNotNull('coach_nama')
            ->where('status', '!=', 'dibatalkan')
            ->whereDoesntHave('coachSession')
            ->get();

        foreach ($orphan as $reservation) {
            $coach = Coach::where('name', $reservation->coach_nama)->first();

            if (! $coach) {
                continue; // pelatih aslinya benar-benar sudah tidak ada, tidak bisa disambungkan lagi
            }

            $reservation->update(['coach_id' => $coach->id]);
            self::buatSesiDariReservasi($reservation, $coach->id);
            $dibuat++;
        }

        return $dibuat;
    }

    private static function buatSesiDariReservasi(Reservation $reservation, int $coachId): void
    {
        $startHour = (int) substr($reservation->waktu, 0, 2);

        CoachSession::create([
            'coach_id' => $coachId,
            'reservation_id' => $reservation->id,
            'type' => 'privat',
            'title' => 'Privat: ' . $reservation->nama_pemesan,
            'session_date' => $reservation->tanggal->toDateString(),
            'start_time' => sprintf('%02d:00', $startHour),
            'end_time' => sprintf('%02d:00', min($startHour + 2, 23)),
            'location' => $reservation->court_nama,
            'notes' => 'Booking Lapangan',
        ]);
    }
}
