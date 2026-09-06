@extends('layouts.app')

@section('title', 'Lapangan')

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-container-margin py-section-gap">
<!-- Header & Filters Section -->
<section class="mb-section-gap">
<h1 class="reveal font-display-lg text-display-lg md:font-display-lg text-secondary mb-stack-lg text-center md:text-left">Pesan <span class="gold-text">Lapangan</span></h1>
<form method="GET" action="{{ route('lapangan') }}" class="bg-surface-container-lowest ambient-shadow rounded-xl p-stack-md md:p-stack-lg border border-outline-variant/30 flex flex-col md:flex-row gap-stack-md items-end">
<div class="w-full md:w-1/3 flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="date-filter">Tanggal</label>
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">calendar_today</span>
<input class="w-full pl-10 pr-4 py-3 min-h-[48px] bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none input-ring transition-shadow" id="date-filter" name="tanggal" type="date" value="{{ $filters['tanggal'] }}" onchange="this.form.submit()">
</div>
</div>
<div class="w-full md:w-1/3 flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="time-filter">Waktu</label>
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">schedule</span>
<select class="w-full pl-10 pr-4 py-3 min-h-[48px] bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none input-ring transition-shadow appearance-none" id="time-filter" name="waktu" onchange="this.form.submit()">
<option value="semua" {{ $filters['waktu'] === 'semua' ? 'selected' : '' }}>Semua Waktu</option>
<option value="pagi" {{ $filters['waktu'] === 'pagi' ? 'selected' : '' }}>Pagi (06:00 - 12:00)</option>
<option value="sore" {{ $filters['waktu'] === 'sore' ? 'selected' : '' }}>Sore (15:00 - 18:00)</option>
<option value="malam" {{ $filters['waktu'] === 'malam' ? 'selected' : '' }}>Malam (18:00 - 22:00)</option>
</select>
<span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
</div>
</div>
<div class="w-full md:w-1/3 flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="type-filter">Tipe Lapangan</label>
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">sports_tennis</span>
<select class="w-full pl-10 pr-4 py-3 min-h-[48px] bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none input-ring transition-shadow appearance-none" id="type-filter" name="tipe" onchange="this.form.submit()">
<option value="semua" {{ $filters['tipe'] === 'semua' ? 'selected' : '' }}>Semua Tipe</option>
<option value="Outdoor Premium" {{ $filters['tipe'] === 'Outdoor Premium' ? 'selected' : '' }}>Outdoor Premium</option>
<option value="Indoor Terbuka" {{ $filters['tipe'] === 'Indoor Terbuka' ? 'selected' : '' }}>Indoor Terbuka</option>
<option value="Semi-Outdoor" {{ $filters['tipe'] === 'Semi-Outdoor' ? 'selected' : '' }}>Semi-Outdoor</option>
</select>
<span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
</div>
</div>
@if ($filters['waktu'] !== 'semua' || $filters['tipe'] !== 'semua')
<a href="{{ route('lapangan') }}" class="w-full md:w-auto text-center px-4 py-3 min-h-[48px] rounded-lg font-label-sm text-label-sm text-outline border border-outline-variant hover:bg-surface-variant/30 transition-colors inline-flex items-center justify-center gap-1">
<span class="material-symbols-outlined text-[16px]">close</span> Reset Filter
</a>
@endif
</form>
</section>
<!-- Court Grid -->
@if ($courts->isEmpty())
<section class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-12 text-center">
<span class="material-symbols-outlined text-outline text-4xl mb-2">search_off</span>
<p class="font-body-md text-body-md text-on-surface-variant">Tidak ada lapangan yang cocok dengan filter ini. Coba ubah tanggal, waktu, atau tipe lapangan.</p>
</section>
@else
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-stack-lg">
@foreach ($courts as $court)
@php
$isPromo = isset($court['harga_coret']);
$diskon = $isPromo ? round((1 - $court['harga'] / $court['harga_coret']) * 100) : 0;
@endphp
<div class="reveal card-hover-lift bg-surface-container-lowest border-outline-variant/20 rounded-lg overflow-hidden ambient-shadow border flex flex-col group transition-transform duration-300">
    <div class="relative h-48 w-full overflow-hidden">
        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $court['nama'] }}" src="{{ $court['gambar_utama'] }}">

        @if ($isPromo)
        <div class="absolute top-4 right-4 bg-tertiary text-on-tertiary px-3 py-1 rounded-full font-label-sm text-label-sm shadow-md">
            Diskon {{ $diskon }}%
        </div>
        @elseif ($court['id'] === 'mawar')
        <div class="absolute top-4 left-4 bg-primary-container text-on-primary-container px-3 py-1 rounded-full font-label-sm text-label-sm flex items-center gap-1 shadow-sm">
            <span class="material-symbols-outlined" style="font-size: 16px;">verified</span> Premium
        </div>
        @endif

        <!-- Muncul saat card dihover/diseleksi kursor -->
        <a href="{{ route('reservasi.detail', $court['id']) }}"
           class="absolute inset-0 flex items-center justify-center bg-inverse-surface/50 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-300">
            <span class="btn-animated bg-secondary text-on-secondary font-label-sm text-label-sm px-6 py-3 rounded-full shadow-lg inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-base">event_available</span>
                Pesan Lapangan Ini
            </span>
        </a>
    </div>
    <div class="p-stack-md flex flex-col flex-grow">
        <div class="flex justify-between items-start mb-base">
            <h2 class="font-headline-md text-headline-md text-secondary">{{ $court['nama'] }}</h2>
        </div>
        <div class="flex items-center text-on-surface-variant font-body-md text-body-md mb-stack-md gap-2">
            <span class="material-symbols-outlined text-outline" style="font-size: 18px;">location_on</span>
            <span>{{ $court['lokasi'] }}</span>
        </div>
        <div class="w-full h-px bg-tertiary/10 mb-stack-md"></div>
        <div class="mb-stack-md">
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-3 uppercase tracking-wider">Slot Tersedia {{ \Illuminate\Support\Carbon::parse($filters['tanggal'])->isToday() ? 'Hari Ini' : 'Tanggal ' . \Illuminate\Support\Carbon::parse($filters['tanggal'])->translatedFormat('d M Y') }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($court['slot'] as $jam)
                    @if (in_array($jam, $court['slot_penuh']))
                    <span class="bg-surface-container-high text-outline px-4 py-2 rounded-full font-label-sm text-label-sm cursor-not-allowed line-through">{{ $jam }}</span>
                    @else
                    <a href="{{ route('reservasi.detail', $court['id']) }}" class="bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary-fixed-dim ring-1 ring-secondary/10 hover:ring-tertiary px-4 py-2 rounded-full font-label-sm text-label-sm transition-colors inline-block">{{ $jam }}</a>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="mt-auto flex justify-between items-center pt-stack-md">
            <div>
                <span class="font-body-md text-body-md text-on-surface-variant block">Mulai dari</span>
                <div class="flex items-baseline gap-2">
                    <span class="font-headline-md text-[17px] font-semibold text-secondary">Rp {{ number_format($court['harga'], 0, ',', '.') }}<span class="font-body-md text-sm font-normal text-on-surface-variant">/jam</span></span>
                    @if ($isPromo)
                    <span class="text-sm line-through opacity-60">Rp {{ number_format($court['harga_coret'], 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
            <a href="{{ route('reservasi.detail', $court['id']) }}" class="btn-animated gold-focus border border-tertiary text-secondary font-label-sm text-label-sm px-5 min-h-[48px] rounded-full hover:bg-tertiary/5 transition-colors inline-flex items-center justify-center">Lihat Detail</a>
        </div>
    </div>
</div>
@endforeach
</section>
@endif
</main>
@endsection
