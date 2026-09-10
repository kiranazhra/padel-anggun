<?php

use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\CoachScheduleController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\FinanceReportController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Supaya format tanggal (translatedFormat) tampil dalam Bahasa Indonesia
// di seluruh halaman, tanpa perlu ubah config/app.php.
\Carbon\Carbon::setLocale('id');

// Halaman publik. redirect.admin: kalau admin sudah login lalu buka halaman
// customer (termasuk beranda), langsung lempar ke panel admin.
Route::middleware('redirect.admin')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('home');

    Route::get('/kebijakan-privasi', function () {
        return view('kebijakan-privasi');
    })->name('kebijakan-privasi');

    Route::get('/syarat-ketentuan', function () {
        return view('syarat-ketentuan');
    })->name('syarat-ketentuan');
});

// Halaman customer yang wajib login sungguhan (bukan sekadar redirect),
// dan otomatis melempar admin ke panel admin (bukan situs customer).
Route::middleware(['auth', 'redirect.admin'])->group(function () {
    Route::get('/lapangan', [ReservationController::class, 'index'])->name('lapangan');

    Route::get('/keanggotaan', [MembershipController::class, 'create'])->name('keanggotaan');
    Route::post('/keanggotaan', [MembershipController::class, 'store'])->name('keanggotaan.store');

    Route::get('/kontak', function () {
        return view('kontak');
    })->name('kontak');

    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $user = $request->user();

        return view('dashboard', [
            'reservasi' => $user->reservations()->latest()->first(),
            'riwayat' => $user->reservations()->latest()->limit(10)->get(),
            'totalMain' => $user->reservations()->where('status', 'terkonfirmasi')->count(),
        ]);
    })->name('dashboard');

    Route::get('/reservasi/{court}', [ReservationController::class, 'show'])->name('reservasi.detail');
    Route::post('/reservasi/{court}', [ReservationController::class, 'store'])->name('reservasi.store');

    // Kelola (batalkan) reservasi milik sendiri dari tombol "Kelola" di dasbor.
    Route::patch('/dashboard/reservasi/{reservation}/batalkan', [ReservationController::class, 'cancel'])->name('reservasi.batalkan');
});

// Profil akun sendiri — dipakai baik oleh customer maupun admin, jadi
// sengaja di luar grup 'redirect.admin' (yang melempar admin ke panel admin).
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Autentikasi (hanya untuk tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Area admin — wajib login DAN akun berstatus admin (bukan sekadar redirect)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen anggota — data asli dari tabel users, aksi beneran (bukan statis)
    Route::get('/anggota', [MemberController::class, 'index'])->name('anggota');
    Route::patch('/anggota/{member}/toggle-admin', [MemberController::class, 'toggleAdmin'])->name('anggota.toggle-admin');
    Route::delete('/anggota/{member}', [MemberController::class, 'destroy'])->name('anggota.destroy');

    // Kelola Lapangan — data asli dari tabel courts, aksi beneran (bukan statis)
    Route::get('/lapangan', [CourtController::class, 'index'])->name('lapangan');
    Route::post('/lapangan', [CourtController::class, 'store'])->name('lapangan.store');
    Route::put('/lapangan/{court}', [CourtController::class, 'update'])->name('lapangan.update');
    Route::patch('/lapangan/{court}/status', [CourtController::class, 'updateStatus'])->name('lapangan.status');
    Route::patch('/lapangan/{court}/toggle-aktif', [CourtController::class, 'toggleActive'])->name('lapangan.toggle-aktif');
    Route::delete('/lapangan/{court}', [CourtController::class, 'destroy'])->name('lapangan.destroy');

    Route::get('/jadwal-pelatih', [CoachScheduleController::class, 'index'])->name('jadwal-pelatih');
    Route::post('/jadwal-pelatih', [CoachScheduleController::class, 'store'])->name('jadwal-pelatih.store');
    Route::put('/jadwal-pelatih/{coachSession}', [CoachScheduleController::class, 'update'])->name('jadwal-pelatih.update');
    Route::delete('/jadwal-pelatih/{coachSession}', [CoachScheduleController::class, 'destroy'])->name('jadwal-pelatih.destroy');
    Route::post('/jadwal-pelatih/sinkronkan', [CoachScheduleController::class, 'syncFromReservations'])->name('jadwal-pelatih.sinkronkan');

    // CRUD data pelatih (nama, spesialisasi, biaya sesi, status aktif)
    Route::post('/pelatih', [CoachController::class, 'store'])->name('pelatih.store');
    Route::put('/pelatih/{coach}', [CoachController::class, 'update'])->name('pelatih.update');
    Route::patch('/pelatih/{coach}/toggle-aktif', [CoachController::class, 'toggleActive'])->name('pelatih.toggle-aktif');
    Route::delete('/pelatih/{coach}', [CoachController::class, 'destroy'])->name('pelatih.destroy');

    // Admin: tambah reservasi manual (form & simpan)
    Route::get('/reservasi/create', [AdminReservationController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [AdminReservationController::class, 'store'])->name('reservasi.store');

    // Pengaturan Promo — data asli dari tabel promos, aksi beneran (bukan statis)
    Route::get('/promo', [PromoController::class, 'index'])->name('promo');
    Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
    Route::put('/promo/{promo}', [PromoController::class, 'update'])->name('promo.update');
    Route::patch('/promo/{promo}/toggle-aktif', [PromoController::class, 'toggleActive'])->name('promo.toggle-aktif');
    Route::delete('/promo/{promo}', [PromoController::class, 'destroy'])->name('promo.destroy');

    // Lihat semua aktivitas admin
    Route::get('/aktivitas', [DashboardController::class, 'activities'])->name('aktivitas');
    Route::post('/aktivitas/mark-read', [DashboardController::class, 'markRead'])->name('aktivitas.mark-read');

    // Admin settings page
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');

    // Admin profile page (view + update)
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Laporan Keuangan — dihitung dari data reservasi asli, plus ekspor CSV
    Route::get('/laporan-keuangan', [FinanceReportController::class, 'index'])->name('laporan-keuangan');
    Route::get('/laporan-keuangan/ekspor', [FinanceReportController::class, 'export'])->name('laporan-keuangan.ekspor');

    // Konfirmasi reservasi oleh admin
    Route::patch('/reservasi/{reservation}/konfirmasi', function (Reservation $reservation) {
        $reservation->update(['status' => 'terkonfirmasi']);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Reservasi ' . $reservation->court_nama . ' telah dikonfirmasi.');
    })->name('reservasi.konfirmasi');

    // Tolak/batalkan reservasi oleh admin
    Route::patch('/reservasi/{reservation}/tolak', function (Reservation $reservation) {
        $reservation->update(['status' => 'dibatalkan']);

        // Bebaskan slot pelatih yang otomatis ter-booking dari reservasi ini,
        // supaya jadwal pelatih tetap sinkron dengan status reservasi terbaru.
        $reservation->coachSession?->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Reservasi ' . $reservation->court_nama . ' ditolak.');
    })->name('reservasi.tolak');
});
