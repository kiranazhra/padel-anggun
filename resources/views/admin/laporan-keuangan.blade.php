@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@php
    $maxTrend = max(1, collect($trend)->max('total'));
    $statusLabel = [
        'menunggu_konfirmasi' => 'Menunggu',
        'terkonfirmasi' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
    $statusClass = [
        'menunggu_konfirmasi' => 'bg-tertiary-container text-on-tertiary-container',
        'terkonfirmasi' => 'bg-secondary-container text-on-secondary-container',
        'dibatalkan' => 'bg-error-container text-on-error-container',
    ];
@endphp

@section('content')
<!-- Main Content Area -->
<div class="flex-1 md:ml-72 flex flex-col min-h-screen">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Laporan', 'titleAccent' => 'Keuangan'])
<!-- Page Content -->
<main class="flex-grow p-container-margin md:p-section-gap bg-surface-container-lowest">
<!-- Date (mobile) + Export Action -->
<div class="flex justify-between items-center mb-stack-lg">
<p class="font-body-md text-body-md text-on-surface-variant md:hidden" id="current-date-mobile">{{ now()->translatedFormat('l, d M Y') }}</p>
<a href="{{ route('admin.laporan-keuangan.ekspor') }}" class="ml-auto px-6 py-3 border border-tertiary text-secondary font-label-sm text-label-sm rounded-lg hover:bg-secondary-container transition-colors duration-200 flex items-center gap-2">
<span class="material-symbols-outlined" data-icon="download">download</span>
                    Ekspor Laporan
                </a>
</div>
<!-- Summary Cards -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-stack-md mb-stack-lg">
<!-- Card 1 -->
<div class="bg-primary-container p-5 rounded-xl shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-white/20 backdrop-blur-sm relative overflow-hidden">
<div class="absolute top-0 right-0 p-4 opacity-20">
<span class="material-symbols-outlined text-[44px]" data-icon="account_balance">account_balance</span>
</div>
<p class="font-label-sm text-label-sm text-on-primary-container mb-2 relative z-10">Total Pendapatan Bulan Ini</p>
<h3 class="font-headline-lg text-headline-lg text-on-primary-fixed mb-4 relative z-10">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
<div class="flex items-center gap-1 {{ $pendapatanPersen >= 0 ? 'text-secondary' : 'text-error' }} font-label-sm text-label-sm relative z-10">
<span class="material-symbols-outlined text-sm" data-icon="trending_up">{{ $pendapatanPersen >= 0 ? 'trending_up' : 'trending_down' }}</span>
<span>{{ $pendapatanPersen >= 0 ? '+' : '' }}{{ $pendapatanPersen }}% dari bulan lalu</span>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-outline-variant/30">
<div class="flex justify-between items-start mb-2">
<p class="font-label-sm text-label-sm text-on-surface-variant">Total Booking Bulan Ini</p>
<span class="material-symbols-outlined text-secondary" data-icon="event_available">event_available</span>
</div>
<h3 class="font-headline-lg text-headline-lg text-primary mb-4">{{ $bookingBulanIni }}</h3>
<div class="flex items-center gap-1 {{ $bookingPersen >= 0 ? 'text-secondary' : 'text-error' }} font-label-sm text-label-sm">
<span class="material-symbols-outlined text-sm" data-icon="trending_up">{{ $bookingPersen >= 0 ? 'trending_up' : 'trending_down' }}</span>
<span>{{ $bookingPersen >= 0 ? '+' : '' }}{{ $bookingPersen }}% dari bulan lalu</span>
</div>
</div>
<!-- Card 3 -->
<div class="bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-outline-variant/30">
<div class="flex justify-between items-start mb-2">
<p class="font-label-sm text-label-sm text-on-surface-variant">Fee Pelatih Bulan Ini</p>
<span class="material-symbols-outlined text-error" data-icon="receipt_long">receipt_long</span>
</div>
<h3 class="font-headline-lg text-headline-lg text-primary mb-4">Rp {{ number_format($feePelatihBulanIni, 0, ',', '.') }}</h3>
<div class="flex items-center gap-1 {{ $feePelatihPersen <= 0 ? 'text-secondary' : 'text-error' }} font-label-sm text-label-sm">
<span class="material-symbols-outlined text-sm" data-icon="trending_down">{{ $feePelatihPersen <= 0 ? 'trending_down' : 'trending_up' }}</span>
<span>{{ $feePelatihPersen >= 0 ? '+' : '' }}{{ $feePelatihPersen }}% dari bulan lalu</span>
</div>
</div>
</section>
<!-- Chart Area (data pendapatan bulanan asli) -->
<section class="bg-surface-container-lowest p-stack-md rounded-xl shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-outline-variant/30 mb-stack-lg">
<div class="flex justify-between items-center mb-stack-md">
<h3 class="font-headline-md text-headline-md text-primary">Tren Pendapatan Bulanan</h3>
<form method="GET">
<select name="year" onchange="this.form.submit()" class="bg-surface border border-outline-variant text-on-surface-variant font-label-sm text-label-sm rounded-lg px-3 py-2 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none">
@foreach (range(now()->year, now()->year - 3) as $y)
<option value="{{ $y }}" @selected($y == $year)>Tahun {{ $y }}</option>
@endforeach
</select>
</form>
</div>
<!-- Bar Chart (tinggi batang proporsional terhadap pendapatan tertinggi tahun ini) -->
<div class="h-64 w-full flex items-end justify-between gap-2 pt-4 relative">
<!-- Y Axis Lines -->
<div class="absolute inset-0 flex flex-col justify-between z-0 pointer-events-none">
<div class="w-full h-px bg-outline-variant/20"></div>
<div class="w-full h-px bg-outline-variant/20"></div>
<div class="w-full h-px bg-outline-variant/20"></div>
<div class="w-full h-px bg-outline-variant/20"></div>
<div class="w-full h-px bg-outline-variant/20"></div>
</div>
<!-- Bars -->
<div class="w-full flex justify-around items-end h-full z-10 pb-6 relative">
@foreach ($trend as $bulan)
@php $isCurrent = $bulan['month'] === now()->month && $year === now()->year; @endphp
<div class="flex flex-col items-center gap-2 group cursor-pointer h-full justify-end w-1/12">
<div class="w-full {{ $isCurrent ? 'bg-secondary shadow-[0_0_8px_rgba(233,195,73,0.4)] border-t border-tertiary-fixed-dim' : 'bg-secondary-container hover:bg-secondary' }} rounded-t-sm transition-all duration-300 relative group" style="height: {{ max(2, round(($bulan['total'] / $maxTrend) * 100)) }}%;">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface font-label-sm text-[9px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Rp {{ number_format($bulan['total'], 0, ',', '.') }}</div>
</div>
<span class="font-label-sm text-[9px] {{ $isCurrent ? 'text-primary font-bold' : 'text-on-surface-variant' }} absolute bottom-0">{{ $bulan['label'] }}</span>
</div>
@endforeach
</div>
</div>
</section>
<!-- Detailed Transaction Table -->
<section class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-outline-variant/30 overflow-hidden">
<div class="p-stack-md border-b border-tertiary/20 flex justify-between items-center bg-surface-bright">
<h3 class="font-headline-md text-headline-md text-primary">Rincian Transaksi Terbaru</h3>
<form method="GET" class="relative">
@if (request('year'))
<input type="hidden" name="year" value="{{ request('year') }}">
@endif
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm" data-icon="search">search</span>
<input name="q" value="{{ $search }}" class="pl-9 pr-4 py-2 border border-outline-variant rounded-lg text-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none w-48 md:w-64 font-body-md bg-surface" placeholder="Cari transaksi..." type="text">
</form>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface text-on-surface-variant font-label-sm text-label-sm border-b border-outline-variant/30">
<th class="py-4 px-6 font-semibold">Tanggal</th>
<th class="py-4 px-6 font-semibold">Nama Pemesan</th>
<th class="py-4 px-6 font-semibold">Layanan</th>
<th class="py-4 px-6 font-semibold text-right">Jumlah (Rp)</th>
<th class="py-4 px-6 font-semibold text-center">Status</th>
</tr>
</thead>
<tbody class="font-body-md text-sm text-on-surface">
@forelse ($transaksi as $t)
<tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
<td class="py-4 px-6">{{ optional($t->tanggal)->translatedFormat('d M Y') }}, {{ $t->waktu }}</td>
<td class="py-4 px-6 font-medium">{{ $t->nama_pemesan }}</td>
<td class="py-4 px-6 text-on-surface-variant">{{ $t->court_nama }}{{ $t->coach_nama ? ' + Pelatih ' . $t->coach_nama : '' }}</td>
<td class="py-4 px-6 text-right font-medium">{{ number_format($t->total_harga, 0, ',', '.') }}</td>
<td class="py-4 px-6 text-center">
<span class="inline-block px-3 py-1 rounded-full {{ $statusClass[$t->status] ?? 'bg-surface-variant text-on-surface-variant' }} font-label-sm text-[9px]">{{ $statusLabel[$t->status] ?? $t->status }}</span>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="py-8 px-6 text-center text-on-surface-variant">
    @if ($search)
        Tidak ada transaksi yang cocok dengan pencarian "{{ $search }}".
    @else
        Belum ada transaksi reservasi.
    @endif
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
@if ($transaksi->hasPages())
<div class="p-4 border-t border-outline-variant/30 bg-surface flex justify-center">
    {{ $transaksi->links() }}
</div>
@endif
</section>
</main>
</div>
@endsection
