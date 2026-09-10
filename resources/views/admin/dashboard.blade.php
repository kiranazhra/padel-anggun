@extends('layouts.admin')

@section('title', 'Dasbor Admin')

@section('content')
<!-- TopNavBar (Mobile Only) -->
<!-- Main Content Area -->
<main class="flex-1 md:ml-72 h-full overflow-y-auto bg-background px-container-margin py-stack-lg">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Ringkasan', 'titleAccent' => 'Utama', 'headerClass' => '-mx-container-margin mb-stack-lg'])
<!-- Page Subtitle -->
<p class="font-body-lg text-outline mb-section-gap">Selamat datang kembali, Admin. Berikut ringkasan hari ini.</p>
<div class="flex flex-col xl:flex-row gap-stack-lg">
<!-- Left Column: Metrics & Chart -->
<div class="flex-1 flex flex-col gap-stack-lg">
<!-- Metrics Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
<!-- Metric 1 -->
<div class="reveal reveal-delay-1 card-hover-lift bg-surface-container-lowest p-stack-md rounded-lg ambient-shadow border border-outline-variant/20 flex flex-col justify-between h-28">
<div class="flex justify-between items-start">
<p class="font-label-sm text-outline">Total Pendapatan (Terkonfirmasi)</p>
<span class="material-symbols-outlined text-secondary opacity-50">payments</span>
</div>
<h3 class="font-headline-md text-on-background">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
</div>
<!-- Metric 2 -->
<div class="reveal reveal-delay-2 card-hover-lift bg-primary-container/30 p-stack-md rounded-lg ambient-shadow border border-outline-variant/20 flex flex-col justify-between h-28">
<div class="flex justify-between items-start">
<p class="font-label-sm text-outline">Total Anggota</p>
<span class="material-symbols-outlined text-secondary opacity-50">group</span>
</div>
<h3 class="font-headline-md text-on-background">{{ $totalAnggota }}</h3>
</div>
<!-- Metric 3 -->
<div class="reveal reveal-delay-3 card-hover-lift bg-surface-container-lowest p-stack-md rounded-lg ambient-shadow border border-outline-variant/20 flex flex-col justify-between h-28">
<div class="flex justify-between items-start">
<p class="font-label-sm text-outline">Total Reservasi</p>
<span class="material-symbols-outlined text-secondary opacity-50">analytics</span>
</div>
<h3 class="font-headline-md text-on-background">{{ $totalReservasi }}</h3>
</div>
<!-- Metric 4 -->
<div class="reveal reveal-delay-4 card-hover-lift pulse-gold bg-secondary-container/30 p-stack-md rounded-lg ambient-shadow gold-border flex flex-col justify-between h-28 relative overflow-hidden">
<div class="absolute top-0 right-0 w-16 h-16 bg-tertiary-fixed-dim/20 rounded-bl-full"></div>
<div class="flex justify-between items-start relative z-10">
<p class="font-label-sm text-outline">Booking Menunggu</p>
<span class="material-symbols-outlined text-tertiary">pending_actions</span>
</div>
<h3 class="font-headline-md text-on-background relative z-10">{{ $reservasiMenunggu->count() }}</h3>
</div>
</div>
<!-- Reservasi Menunggu Konfirmasi -->
<div class="reveal reveal-delay-3 bg-surface-container-lowest rounded-lg p-stack-lg ambient-shadow border border-outline-variant/20">
<div class="flex justify-between items-center mb-stack-md">
<h3 class="font-headline-md text-on-background">Reservasi Menunggu Konfirmasi</h3>
<span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full font-label-sm text-label-sm">{{ $reservasiMenunggu->count() }} pending</span>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant/30 text-on-surface-variant font-label-sm text-label-sm uppercase">
<th class="pb-3 font-semibold">Pemesan</th>
<th class="pb-3 font-semibold">Lapangan</th>
<th class="pb-3 font-semibold">Pelatih</th>
<th class="pb-3 font-semibold">Tanggal &amp; Waktu</th>
<th class="pb-3 font-semibold">Total</th>
<th class="pb-3 font-semibold text-right">Aksi</th>
</tr>
</thead>
<tbody class="font-body-md text-body-md text-on-background">
@forelse ($reservasiMenunggu as $item)
<tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
<td class="py-3">{{ $item->nama_pemesan }}</td>
<td class="py-3">{{ $item->court_nama }}<br><span class="text-xs text-outline">{{ $item->lokasi }}</span></td>
<td class="py-3">{{ $item->coach_nama ?? '-' }}</td>
<td class="py-3">{{ $item->tanggal->translatedFormat('d M Y') }}<br><span class="text-xs text-outline">{{ $item->waktu }}</span></td>
<td class="py-3">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
<td class="py-3">
<div class="flex justify-end gap-2">
<form method="POST" action="{{ route('admin.reservasi.konfirmasi', $item->id) }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="bg-secondary text-on-secondary px-4 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">Konfirmasi</button>
</form>
<form method="POST" action="{{ route('admin.reservasi.tolak', $item->id) }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="border border-outline-variant text-on-surface-variant px-4 py-2 rounded-lg font-label-sm text-label-sm hover:bg-surface-container-high transition-colors">Tolak</button>
</form>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="py-8 text-center text-on-surface-variant">Tidak ada reservasi yang menunggu konfirmasi saat ini.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
<!-- Chart Section (data pendapatan mingguan asli dari database) -->
@php
    $maxTrendMingguan = max(1, collect($trendMingguan['hari'])->max('total'));
@endphp
<div class="reveal reveal-delay-2 bg-surface-container-lowest rounded-lg p-stack-lg ambient-shadow border border-outline-variant/20">
<div class="flex justify-between items-center mb-stack-md flex-wrap gap-2">
<div>
<h3 class="font-headline-md text-on-background">Tren Pendapatan Mingguan</h3>
<p class="font-label-sm text-xs text-outline mt-1">{{ $trendMingguan['start']->translatedFormat('d M') }} - {{ $trendMingguan['end']->translatedFormat('d M Y') }}</p>
</div>
<form method="GET" class="flex items-center gap-2">
<label for="minggu-filter" class="sr-only">Pilih minggu</label>
<input type="date" id="minggu-filter" name="minggu" value="{{ $trendMingguan['start']->toDateString() }}" onchange="this.form.submit()" class="bg-surface border border-outline-variant text-on-surface-variant font-label-sm text-label-sm rounded-lg px-3 py-2 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none">
@if(request()->query('minggu'))
<a href="{{ route('admin.dashboard') }}" class="text-secondary font-label-sm text-label-sm hover:underline whitespace-nowrap">Minggu Ini</a>
@endif
</form>
</div>
<!-- Bar Chart (tinggi batang proporsional terhadap pendapatan tertinggi minggu ini) -->
<div class="h-64 w-full flex items-end justify-between gap-2 pt-4 border-b border-outline-variant/30 pb-2 relative">
<!-- Y-axis labels (skala mengikuti pendapatan tertinggi minggu berjalan) -->
<div class="absolute left-0 top-0 bottom-0 flex flex-col justify-between text-xs text-outline opacity-50 -ml-2 transform -translate-x-full">
<span>Rp {{ number_format($maxTrendMingguan, 0, ',', '.') }}</span>
<span>Rp {{ number_format((int) round($maxTrendMingguan / 2), 0, ',', '.') }}</span>
<span>0</span>
</div>
<div class="w-full flex justify-around items-end h-full px-4">
@foreach ($trendMingguan['hari'] as $hari)
<div class="w-1/12 {{ $hari['isToday'] ? 'bg-secondary' : 'bg-primary-container' }} {{ $hari['isToday'] ? 'hover:bg-secondary-fixed' : 'hover:bg-primary' }} rounded-t-sm transition-colors cursor-pointer relative group" style="height: {{ max(2, round(($hari['total'] / $maxTrendMingguan) * 100)) }}%;">
<span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-surface shadow-sm px-2 py-1 text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">Rp {{ number_format($hari['total'], 0, ',', '.') }}</span>
</div>
@endforeach
</div>
</div>
<div class="flex justify-around text-xs text-outline mt-2 px-4">
@foreach ($trendMingguan['hari'] as $hari)
<span class="{{ $hari['isToday'] ? 'text-secondary font-bold' : '' }}">{{ $hari['label'] }}</span>
@endforeach
</div>
</div>
</div>
<!-- Right Sidebar: Recent Activity -->
<div class="w-full xl:w-80 flex flex-col gap-stack-md">
<div class="bg-surface-container-lowest rounded-lg p-stack-md ambient-shadow border border-outline-variant/20 flex-1">
<h3 class="font-headline-md text-on-background mb-stack-md">Aktivitas Terkini</h3>
<div class="flex flex-col gap-4">
@forelse ($aktivitas as $item)
<!-- Activity Item -->
<div class="flex gap-stack-sm pb-4 border-b border-outline-variant/20 last:border-0 last:pb-0">
<div class="w-8 h-8 rounded-full {{ $item['iconBg'] }} flex items-center justify-center shrink-0">
<span class="material-symbols-outlined {{ $item['iconColor'] }} text-sm">{{ $item['icon'] }}</span>
</div>
<div>
<p class="font-body-md text-sm text-on-background">{!! $item['text'] !!}</p>
<p class="font-label-sm text-xs text-outline mt-1">{{ $item['time']->diffForHumans() }}</p>
</div>
</div>
@empty
<p class="font-body-md text-sm text-outline">Belum ada aktivitas.</p>
@endforelse
</div>
            <a href="{{ route('admin.aktivitas') }}" class="w-full mt-stack-md py-2 border border-secondary text-secondary rounded-lg font-label-sm hover:bg-secondary/5 transition-colors text-center inline-block">Lihat Semua Aktivitas</a>
</div>
            <div class="mt-stack-md">
                <div class="bg-inverse-surface text-inverse-on-surface rounded-lg p-3 shadow-sm w-full relative">
                    <div class="absolute top-3 right-3 flex items-center gap-2">
                        <button id="notifToggle" type="button" title="Notifikasi" class="relative p-2 rounded-full hover:bg-surface-container-high" data-mark-read-url="{{ route('admin.aktivitas.mark-read') }}" data-csrf-token="{{ csrf_token() }}" data-admin-url="{{ url('/admin') }}">
                            <span class="material-symbols-outlined">notifications</span>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                <span id="notifBadge" class="absolute -top-1 -right-1 bg-secondary text-on-secondary text-xs rounded-full px-1">{{ $unreadNotifications }}</span>
                            @endif
                        </button>
                        <a href="{{ route('admin.settings') }}" title="Pengaturan" class="p-2 rounded-full hover:bg-surface-container-high">
                            <span class="material-symbols-outlined">settings</span>
                        </a>
                    </div>

                    <h4 class="font-label-md mb-1">Butuh Bantuan?</h4>
                    <p class="font-body-sm text-sm text-outline mb-3">Hubungi tim support IT jika ada kendala sistem.</p>
                    <a id="help-action" href="https://wa.me/6281199887766?text={{ urlencode('Halo tim support Padel Anggun, saya butuh bantuan terkait panel admin.') }}" target="_blank" rel="noopener noreferrer" class="bg-tertiary-fixed text-on-tertiary-fixed px-3 py-1 rounded-md font-label-sm flex items-center gap-2 hover:bg-tertiary-fixed-dim transition-colors w-fit">
                        <span class="material-symbols-outlined text-sm">support_agent</span>
                        Hubungi Support
                    </a>
                </div>
            </div>

            <!-- Notifications Modal (right-side) -->
            <div id="notifModal" class="fixed inset-0 z-50 hidden bg-black/40">
                <div class="bg-surface-container-lowest rounded-lg w-full max-w-md p-4 absolute top-16 right-6 max-h-[70vh] overflow-hidden">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-headline-sm">Notifikasi</h3>
                        <button id="notifClose" class="p-1">&times;</button>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @if($aktivitas->isEmpty())
                            <p class="text-sm text-outline">Belum ada notifikasi.</p>
                        @else
                            @foreach($aktivitas->take(10) as $note)
                                <div class="py-2 border-b border-outline-variant/10">
                                    <p class="font-body-sm text-sm">{!! $note['text'] !!}</p>
                                    <p class="font-label-sm text-xs text-outline">{{ $note['time']->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mt-3 text-right">
                        <a href="{{ route('admin.aktivitas') }}" class="text-secondary hover:underline">Lihat semua</a>
                    </div>
                </div>
            </div>

            <!-- settings now open the admin settings page -->

            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const notifToggle = document.getElementById('notifToggle');
                    const notifModal = document.getElementById('notifModal');
                    const notifClose = document.getElementById('notifClose');
                    const notifBadge = document.getElementById('notifBadge');

                    const show = (el) => el && el.classList.remove('hidden');
                    const hide = (el) => el && el.classList.add('hidden');

                    const markReadUrl = notifToggle ? notifToggle.dataset.markReadUrl : null;
                    const csrfToken = notifToggle ? notifToggle.dataset.csrfToken : null;
                    const adminBaseUrl = notifToggle ? notifToggle.dataset.adminUrl : null;

                    if(notifToggle){
                        notifToggle.addEventListener('click', function(){
                            // Mark notifications as read via POST and then show modal
                            fetch(markReadUrl, {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({})
                            }).then((res) => {
                                if(notifBadge) notifBadge.remove();
                                const headerBadge = document.getElementById('headerNotifBadge');
                                if(headerBadge) headerBadge.remove();
                                show(notifModal);
                            }).catch((err) => {
                                // still show modal even if request fails
                                console.warn('Mark-read failed', err);
                                show(notifModal);
                            });
                        });
                    }

                    // Also wire header notification button (if present) to open modal on this page
                    const headerNotif = document.getElementById('headerNotifBtn');
                    if(headerNotif){
                        headerNotif.addEventListener('click', function(e){
                            // If we're on dashboard, prevent navigation and show modal
                            if(window.location.pathname === adminBaseUrl || window.location.pathname === (adminBaseUrl + '/') || window.location.pathname.endsWith('/admin')){
                                e.preventDefault();
                                if(notifToggle) notifToggle.click();
                            }
                            // otherwise default link navigates to activities page
                        });
                    }

                    if(notifClose) notifClose.addEventListener('click', () => hide(notifModal));
                    if(notifModal) notifModal.addEventListener('click', (e) => { if(e.target === notifModal) hide(notifModal); });
                });
            </script>
</div>
</div>
</div>
<!-- Footer -->
<footer class="w-full py-stack-md mt-section-gap border-t border-outline-variant/20 flex justify-between items-center px-container-margin">
<span class="font-body-md text-label-sm text-outline">© 2024 Klub Padel Anggun. All rights reserved.</span>
<div class="flex gap-stack-md">
<a class="font-body-md text-label-sm text-outline hover:text-secondary underline-offset-4 hover:underline transition-colors" href="#">Syarat &amp; Ketentuan</a>
<a class="font-body-md text-label-sm text-outline hover:text-secondary underline-offset-4 hover:underline transition-colors" href="#">Kebijakan Privasi</a>
<a class="font-body-md text-label-sm text-outline hover:text-secondary underline-offset-4 hover:underline transition-colors" href="#">Kontak</a>
</div>
</footer>
</main>
@endsection
