@extends('layouts.admin')

@section('title', 'Manajemen Anggota')

@section('content')
<!-- Main Content -->
<main class="flex-1 md:ml-72 flex flex-col min-h-screen">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Manajemen', 'titleAccent' => 'Anggota'])
<div class="p-container-margin md:p-section-gap flex-1">
<!-- Page Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-stack-lg gap-4">
<div>
<p class="font-body-md text-body-md text-outline">Semua akun yang terdaftar lewat sistem autentikasi ({{ $members->total() }} akun).</p>
</div>
</div>

@if (session('status'))
<div class="mb-stack-lg bg-secondary-container text-on-secondary-container border border-secondary/30 rounded-lg px-4 py-3 flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-body-md text-body-md">{{ session('status') }}</span>
</div>
@endif

<!-- Search Bar -->
<div class="bg-surface-container-lowest rounded-xl p-4 shadow-ambient mb-stack-lg">
<form method="GET" action="{{ route('admin.anggota') }}" class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
<input class="w-full pl-10 pr-4 py-3 rounded-lg border border-primary-container focus:border-secondary focus:ring-1 focus:ring-secondary bg-surface-container-lowest font-body-md text-body-md outline-none transition-all" name="q" value="{{ $search }}" placeholder="Cari nama atau email anggota..." type="text">
</form>
</div>

<!-- Member Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
@forelse ($members as $member)
<div class="bg-surface-container-lowest rounded-xl p-5 shadow-ambient hover:-translate-y-1 transition-transform duration-300 group border {{ $member->is_admin ? 'gold-border' : 'border-transparent' }}">
<div class="flex justify-between items-start mb-4">
<div class="flex items-center gap-3">
<div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-headline-md text-headline-md">
    {{ strtoupper(substr($member->name, 0, 2)) }}
</div>
<div>
<h3 class="font-headline-md text-body-lg font-semibold text-on-surface">{{ $member->name }}</h3>
<p class="font-body-md text-label-sm text-outline">{{ $member->email }}</p>
</div>
</div>
</div>
<div class="flex gap-2 mb-6 flex-wrap">
@if ($member->is_admin)
<span class="px-3 py-1 bg-tertiary-container/30 text-tertiary rounded-full font-body-md text-label-sm flex items-center gap-1 border border-tertiary-fixed-dim/50">
<span class="material-symbols-outlined text-[12px]">shield_person</span> Admin
</span>
@else
<span class="px-3 py-1 bg-secondary-container/50 text-on-secondary-container rounded-full font-body-md text-label-sm">
    Anggota
</span>
@endif
@if ($member->membershipLabel())
<span class="px-3 py-1 rounded-full font-body-md text-label-sm flex items-center gap-1 border
    @if ($member->membership_tier === 'gold') bg-amber-100 text-amber-800 border-amber-300
    @elseif ($member->membership_tier === 'elite') bg-slate-200 text-slate-700 border-slate-400
    @else bg-primary-container text-on-primary-container border-primary @endif">
<span class="material-symbols-outlined text-[12px]">workspace_premium</span> {{ $member->membershipLabel() }}
</span>
@endif
</div>
<div class="space-y-2 mb-6 border-t border-outline-variant/20 pt-4">
<div class="flex justify-between">
<span class="font-body-md text-label-sm text-outline">Telepon</span>
<span class="font-body-md text-label-sm text-on-surface">{{ $member->phone ?? '—' }}</span>
</div>
<div class="flex justify-between">
<span class="font-body-md text-label-sm text-outline">Bergabung</span>
<span class="font-body-md text-label-sm text-on-surface">{{ $member->created_at->translatedFormat('d M Y') }}</span>
</div>
<div class="flex justify-between">
<span class="font-body-md text-label-sm text-outline">Total Reservasi</span>
<span class="font-body-md text-label-sm text-on-surface">{{ $member->reservations_count }}x</span>
</div>
<div class="flex justify-between items-center">
<span class="font-body-md text-label-sm text-outline">Status Pembayaran</span>
@if ($member->total_terkonfirmasi > 0)
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container rounded-full font-body-md text-[10px] font-semibold">
    Lunas Rp {{ number_format($member->total_terkonfirmasi, 0, ',', '.') }}
</span>
@elseif ($member->reservasi_menunggu_count > 0)
<span class="px-2 py-0.5 bg-tertiary-container/40 text-tertiary rounded-full font-body-md text-[10px] font-semibold">
    Menunggu Pembayaran
</span>
@else
<span class="px-2 py-0.5 bg-surface-variant text-on-surface-variant rounded-full font-body-md text-[10px] font-semibold">
    Belum Ada Transaksi
</span>
@endif
</div>
</div>
<div class="flex gap-2">
<form method="POST" action="{{ route('admin.anggota.toggle-admin', $member) }}" class="flex-1">
    @csrf
    @method('PATCH')
    <button type="submit" class="w-full py-2 rounded-lg border border-primary-container text-secondary font-body-md text-label-sm hover:bg-surface-container transition-colors">
        {{ $member->is_admin ? 'Cabut Admin' : 'Jadikan Admin' }}
    </button>
</form>
<form method="POST" action="{{ route('admin.anggota.destroy', $member) }}"
      onsubmit="return confirm('Hapus akun {{ $member->name }}? Tindakan ini tidak bisa dibatalkan.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="py-2 px-3 rounded-lg border border-error/40 text-error font-body-md text-label-sm hover:bg-error-container/30 transition-colors">
        <span class="material-symbols-outlined text-[18px] align-middle">delete</span>
    </button>
</form>
</div>
</div>
@empty
<div class="col-span-full text-center py-12 text-on-surface-variant">
    Tidak ada anggota yang cocok dengan pencarian.
</div>
@endforelse
</div>

<!-- Pagination -->
<div class="mt-stack-lg">
    {{ $members->links() }}
</div>
</div>
<!-- Footer -->
<footer class="w-full py-stack-md mt-auto flex justify-between items-center px-container-margin bg-surface-container-lowest dark:bg-surface-dim border-t border-outline-variant/20">
<p class="font-body-md text-label-sm text-outline dark:text-outline-variant">© 2024 Klub Padel Anggun. All rights reserved.</p>
</footer>
</main>
@endsection
