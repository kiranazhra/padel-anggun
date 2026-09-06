@extends('layouts.app')

@section('title', 'Dasbor Anggota')

@section('content')
<main class="flex-grow px-container-margin py-section-gap max-w-[1200px] mx-auto w-full">

@if (session('status'))
<div class="reveal mb-stack-lg bg-secondary-container text-on-secondary-container border border-secondary/30 rounded-lg px-stack-md py-4 flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-body-md text-body-md">{{ session('status') }}</span>
</div>
@endif

<!-- Header Section -->
<header class="mb-stack-lg flex flex-col md:flex-row justify-between items-start md:items-end gap-stack-md">
<div>
<h1 class="reveal font-headline-lg text-headline-lg text-secondary mb-stack-sm">Selamat datang kembali, <span class="gold-text">{{ auth()->user()->name }}</span></h1>
<p class="font-body-md text-body-md text-on-surface-variant">
    @if ($reservasi)
        Anda memiliki 1 pertandingan terjadwal. Siap untuk bermain?
    @else
        Belum ada pertandingan terjadwal. Yuk pesan lapangan pertamamu!
    @endif
</p>
</div>
<div class="flex gap-4">
<div class="text-center px-4 py-2">
<span class="block font-headline-md text-headline-md text-tertiary">{{ $totalMain }}</span>
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Total Main</span>
</div>
</div>
</header>
<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Pertandingan Berikutnya (Span 2) -->
@if ($reservasi)
<div class="reveal reveal-delay-1 card-hover-lift lg:col-span-2 bg-secondary rounded-xl p-5 text-on-secondary elegant-shadow relative overflow-hidden flex flex-col justify-between min-h-[220px]">
<div class="absolute -top-24 -right-24 w-64 h-64 bg-tertiary/20 rounded-full blur-3xl"></div>
<div class="relative z-10">
<div class="flex justify-between items-center mb-6">
<h2 class="font-headline-md text-headline-md text-tertiary-fixed">Pertandingan Berikutnya</h2>
@if ($reservasi->isTerkonfirmasi())
<span class="bg-tertiary-fixed/20 text-tertiary-fixed font-label-sm text-label-sm px-3 py-1 rounded-full border border-tertiary-fixed/50">Terkonfirmasi</span>
@elseif ($reservasi->status === 'dibatalkan')
<span class="bg-error-container text-on-error-container font-label-sm text-label-sm px-3 py-1 rounded-full border border-error/50">Dibatalkan</span>
@else
<span class="bg-surface-bright/90 text-secondary font-label-sm text-label-sm px-3 py-1 rounded-full border border-surface-bright animate-pulse">Menunggu Konfirmasi</span>
@endif
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
<div>
<p class="font-label-sm text-label-sm text-secondary-fixed-dim uppercase mb-1">Tanggal &amp; Waktu</p>
<p class="font-body-lg text-body-lg font-semibold">{{ $reservasi->tanggal->translatedFormat('l, d M Y') }}<br>{{ $reservasi->waktu }}</p>
</div>
<div>
<p class="font-label-sm text-label-sm text-secondary-fixed-dim uppercase mb-1">Lokasi</p>
<p class="font-body-lg text-body-lg font-semibold">{{ $reservasi->court_nama }}<br><span class="text-secondary-fixed-dim text-sm">{{ $reservasi->lokasi }}</span></p>
</div>
<div>
<p class="font-label-sm text-label-sm text-secondary-fixed-dim uppercase mb-1">Pelatih</p>
<p class="font-body-lg text-body-lg font-semibold">{{ $reservasi->coach_nama ?? 'Tanpa Pelatih' }}</p>
</div>
<div>
<p class="font-label-sm text-label-sm text-secondary-fixed-dim uppercase mb-1">Total Biaya</p>
<p class="font-body-lg text-body-lg font-semibold">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
</div>
</div>
</div>
<div class="relative z-10 flex gap-4 mt-auto">
<button class="btn-animated bg-tertiary text-on-tertiary font-label-sm text-label-sm h-12 px-8 rounded-lg hover:bg-tertiary/90 transition-colors">
    Kelola
</button>
<button class="border border-outline-variant text-on-secondary font-label-sm text-label-sm h-12 px-8 rounded-lg hover:bg-white/10 transition-colors" onclick="location.href='{{ route('lapangan') }}'">
    Pesan Lagi
</button>
</div>
</div>
@else
<div class="reveal reveal-delay-1 lg:col-span-2 bg-surface-container-lowest rounded-xl p-5 elegant-shadow border border-dashed border-outline-variant flex flex-col items-center justify-center text-center min-h-[220px] gap-4">
<span class="material-symbols-outlined text-tertiary text-4xl">sports_tennis</span>
<div>
<h2 class="font-headline-md text-headline-md text-secondary mb-1">Belum Ada Pertandingan</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Pesan lapangan pertamamu dan mulai bermain bersama Padel Anggun.</p>
</div>
<button class="btn-animated bg-secondary text-on-secondary font-label-sm text-label-sm h-12 px-8 rounded-lg hover:bg-secondary/90 transition-colors" onclick="location.href='{{ route('lapangan') }}'">
    Pesan Lapangan
</button>
</div>
@endif
<!-- Keanggotaan (Span 1) -->
<div class="reveal reveal-delay-2 card-hover-lift lg:col-span-1 bg-primary-container rounded-xl p-5 text-on-primary-container elegant-shadow flex flex-col border border-outline-variant/30">
<div class="flex items-center gap-3 mb-6">
<span class="material-symbols-outlined text-tertiary text-3xl">workspace_premium</span>
<h2 class="font-headline-md text-headline-md text-secondary">Keanggotaan</h2>
</div>
@if (auth()->user()->membershipLabel())
<div class="mb-6 pb-6 border-b border-primary/20">
<p class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/70 mb-1">Status Anda</p>
<h3 class="font-headline-lg-mobile text-headline-lg-mobile text-secondary font-bold">{{ auth()->user()->membershipLabel() }} Tier</h3>
<p class="font-body-md text-body-md text-on-primary-container/80 mt-2">Anggota sejak {{ auth()->user()->created_at->translatedFormat('d M Y') }}</p>
</div>
<ul class="space-y-4 font-body-md text-body-md flex-grow">
@foreach (auth()->user()->membershipPerks() as $perk)
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-tertiary text-sm mt-1">check_circle</span>
<span>{{ $perk }}</span>
</li>
@endforeach
</ul>
<button class="mt-8 border border-tertiary text-secondary font-label-sm text-label-sm h-12 w-full rounded-lg hover:bg-tertiary/10 transition-colors" onclick="location.href='{{ route('keanggotaan') }}'">
    Perbarui Keanggotaan
</button>
@else
<div class="mb-6 pb-6 border-b border-primary/20 flex-grow">
<p class="font-label-sm text-label-sm uppercase tracking-wider text-on-primary-container/70 mb-1">Status Anda</p>
<h3 class="font-headline-lg-mobile text-headline-lg-mobile text-secondary font-bold">Belum Jadi Anggota</h3>
<p class="font-body-md text-body-md text-on-primary-container/80 mt-2">Daftar paket keanggotaan untuk nikmati prioritas booking, diskon pro shop, dan lebih banyak lagi.</p>
</div>
<button class="mt-8 bg-secondary text-on-secondary font-label-sm text-label-sm h-12 w-full rounded-lg hover:bg-secondary/90 transition-colors" onclick="location.href='{{ route('keanggotaan') }}'">
    Daftar Jadi Anggota
</button>
@endif
</div>
<!-- Riwayat Pertandingan (Span 3) -->
<div class="reveal reveal-delay-3 lg:col-span-3 bg-surface-container-lowest rounded-xl p-5 elegant-shadow border border-outline-variant/20 mt-4">
<div class="flex justify-between items-center mb-6">
<h2 class="font-headline-md text-headline-md text-secondary">Riwayat Pertandingan</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant/30 text-on-surface-variant font-label-sm text-label-sm uppercase">
<th class="pb-4 font-semibold">Tanggal</th>
<th class="pb-4 font-semibold">Lapangan</th>
<th class="pb-4 font-semibold">Waktu</th>
<th class="pb-4 font-semibold">Pelatih</th>
<th class="pb-4 font-semibold">Status</th>
</tr>
</thead>
<tbody class="font-body-md text-body-md text-on-surface">
@forelse ($riwayat as $item)
<tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
<td class="py-4">{{ $item->tanggal->translatedFormat('d M Y') }}</td>
<td class="py-4">{{ $item->court_nama }}</td>
<td class="py-4">{{ $item->waktu }}</td>
<td class="py-4">{{ $item->coach_nama ?? '-' }}</td>
<td class="py-4">
    @if ($item->isTerkonfirmasi())
    <span class="bg-secondary-fixed/50 text-on-secondary-fixed px-3 py-1 rounded-full text-xs font-semibold">Terkonfirmasi</span>
    @elseif ($item->status === 'dibatalkan')
    <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-xs font-semibold">Dibatalkan</span>
    @else
    <span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-xs font-semibold">Menunggu Konfirmasi</span>
    @endif
</td>
</tr>
@empty
<tr>
<td colspan="5" class="py-8 text-center text-on-surface-variant">Belum ada riwayat reservasi.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</main>
@endsection
