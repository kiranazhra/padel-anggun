<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinanceReportController extends Controller
{
    public function index(Request $request): View
    {
        $year = (int) ($request->query('year') ?: now()->year);
        $search = trim((string) $request->query('q', ''));

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfLastMonth = now()->subMonthNoOverflow()->startOfMonth();
        $endOfLastMonth = now()->subMonthNoOverflow()->endOfMonth();

        $pendapatanBulanIni = $this->revenueBetween($startOfMonth, $endOfMonth);
        $pendapatanBulanLalu = $this->revenueBetween($startOfLastMonth, $endOfLastMonth);

        $bookingBulanIni = Reservation::whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->where('status', '!=', 'dibatalkan')
            ->count();
        $bookingBulanLalu = Reservation::whereBetween('tanggal', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])
            ->where('status', '!=', 'dibatalkan')
            ->count();

        // "Pengeluaran operasional" dihitung dari total fee pelatih yang
        // sudah dibayarkan lewat reservasi terkonfirmasi bulan ini — satu-
        // satunya biaya operasional yang benar-benar tercatat di database.
        $feePelatihBulanIni = (int) Reservation::whereBetween('tanggal', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->where('status', 'terkonfirmasi')
            ->sum('coach_fee');
        $feePelatihBulanLalu = (int) Reservation::whereBetween('tanggal', [$startOfLastMonth->toDateString(), $endOfLastMonth->toDateString()])
            ->where('status', 'terkonfirmasi')
            ->sum('coach_fee');

        $trend = $this->monthlyTrend($year);

        $transaksi = Reservation::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_pemesan', 'like', "%{$search}%")
                        ->orWhere('court_nama', 'like', "%{$search}%")
                        ->orWhere('coach_nama', 'like', "%{$search}%");
                });
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan-keuangan', [
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pendapatanBulanLalu' => $pendapatanBulanLalu,
            'pendapatanPersen' => $this->percentChange($pendapatanBulanLalu, $pendapatanBulanIni),
            'bookingBulanIni' => $bookingBulanIni,
            'bookingBulanLalu' => $bookingBulanLalu,
            'bookingPersen' => $this->percentChange($bookingBulanLalu, $bookingBulanIni),
            'feePelatihBulanIni' => $feePelatihBulanIni,
            'feePelatihPersen' => $this->percentChange($feePelatihBulanLalu, $feePelatihBulanIni),
            'trend' => $trend,
            'year' => $year,
            'transaksi' => $transaksi,
            'search' => $search,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $reservations = Reservation::query()->orderByDesc('created_at')->get();

        $filename = 'laporan-keuangan-' . now()->format('Y-m-d') . '.csv';

        return Response::streamDownload(function () use ($reservations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Nama Pemesan', 'Layanan', 'Jumlah (Rp)', 'Status']);

            foreach ($reservations as $r) {
                $layanan = $r->court_nama . ($r->coach_nama ? ' + Pelatih ' . $r->coach_nama : '');
                fputcsv($handle, [
                    optional($r->tanggal)->format('d-m-Y') . ' ' . $r->waktu,
                    $r->nama_pemesan,
                    $layanan,
                    $r->total_harga,
                    $r->status,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function revenueBetween(Carbon $start, Carbon $end): int
    {
        return (int) Reservation::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->where('status', 'terkonfirmasi')
            ->sum('total_harga');
    }

    /**
     * @return array<int, array{label: string, total: int}>
     */
    private function monthlyTrend(int $year): array
    {
        // Dikelompokkan di PHP (bukan raw SQL per-driver) supaya query tetap
        // portable antara SQLite (dev) dan MySQL (produksi).
        $totals = Reservation::whereYear('tanggal', $year)
            ->where('status', 'terkonfirmasi')
            ->get(['tanggal', 'total_harga'])
            ->groupBy(fn ($r) => $r->tanggal->format('m'))
            ->map(fn ($group) => (int) $group->sum('total_harga'));

        $namaBulan = ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];

        $result = [];
        foreach ($namaBulan as $key => $label) {
            $result[] = ['label' => $label, 'month' => (int) $key, 'total' => (int) ($totals[$key] ?? 0)];
        }

        return $result;
    }

    private function percentChange(int $before, int $after): float
    {
        if ($before <= 0) {
            return $after > 0 ? 100.0 : 0.0;
        }

        return round((($after - $before) / $before) * 100, 1);
    }
}
