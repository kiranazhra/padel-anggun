@extends('layouts.app')

@section('title', 'Keanggotaan')

@section('content')
<!-- Fixed Background Image -->
<div class="fixed inset-0 z-0">
<div class="absolute inset-0 bg-cover bg-center w-full h-full" data-alt="Lapangan padel butik eksklusif dengan aksen pink dan hijau forest, suasana senja yang hangat." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCin2WqGZ-XVYKY2hNF2lbFMpSNxebKmF02q6DNN0i-4fe2BaAvyuIxtPu5ZAJml_irvyHBipz24HYWY0VrtUjyaYgT6ksK-JkhgUMMgQ-gMd6th-9zXkKv7nH60jlPC390yO3c6eBRcSN3zXIWFmiSX70HEpLPDeipBQP6g6qhauAOdc6dfuKSWqqpz1qUftjOrnT5H1jDb73H4RFkzKvTlJZzw_dkifBFfV4k9WYTD4T1hDWeDfVLTw')"></div>
<div class="absolute inset-0 bg-black/60 mix-blend-multiply"></div>
</div>
<!-- Main -->
<main class="relative z-10 flex flex-col items-center justify-center py-section-gap px-container-margin w-full max-w-7xl mx-auto">
<div class="reveal text-center mb-stack-lg w-full">
    <a href="{{ route('home') }}" class="block mb-4">
        <img src="{{ asset('img/logo-padel-anggun2.png') }}" alt="Padel Anggun" class="mx-auto h-20">
    </a>
    <h2 class="font-headline-md text-headline-md text-surface-bright mb-stack-sm">Pendaftaran Keanggotaan</h2>
    <p class="font-body-md text-body-md text-surface-variant">Bergabunglah dengan Klub Padel Anggun dan nikmati pengalaman bermain padel yang eksklusif.</p>
</div>
<div class="reveal reveal-delay-1 relative w-full max-w-3xl bg-surface-container-lowest rounded-lg shadow-xl p-container-margin md:p-stack-lg">

@if (session('status'))
<div class="mb-stack-md rounded-lg bg-secondary-container text-on-secondary-container border border-secondary/30 px-4 py-3 text-body-md">
    {{ session('status') }}
</div>
@endif

@if ($errors->any())
<div class="mb-stack-md rounded-lg bg-error-container text-on-error-container border border-error/40 px-4 py-3 text-body-md">
    <ul class="list-disc pl-4">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (auth()->user()->membership_tier)
<div class="mb-stack-md rounded-lg bg-tertiary-container/40 text-tertiary border border-tertiary-fixed-dim/50 px-4 py-3 text-body-md">
    Kamu sudah terdaftar sebagai anggota paket <strong>{{ auth()->user()->membershipLabel() }}</strong>. Pilih paket lain di bawah untuk berganti paket.
</div>
@endif

<form action="{{ route('keanggotaan.store') }}" class="flex flex-col gap-stack-md" method="POST">
@csrf
<!-- Informasi Pribadi -->
<div class="flex flex-col gap-stack-md pb-stack-md border-b border-surface-container-highest border-opacity-50">
<h2 class="font-headline-md text-headline-md text-secondary">Informasi Pribadi</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="fullName">Nama Lengkap</label>
<input class="bg-surface-variant/30 rounded-lg border border-primary-container px-4 py-3 font-body-md text-body-md text-on-surface outline-none cursor-not-allowed" id="fullName" value="{{ auth()->user()->name }}" readonly type="text"/>
</div>
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="email">Alamat Email</label>
<input class="bg-surface-variant/30 rounded-lg border border-primary-container px-4 py-3 font-body-md text-body-md text-on-surface outline-none cursor-not-allowed" id="email" value="{{ auth()->user()->email }}" readonly type="email"/>
</div>
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant" for="phone">Nomor Telepon</label>
<input class="bg-surface-variant/30 rounded-lg border border-primary-container px-4 py-3 font-body-md text-body-md text-on-surface outline-none cursor-not-allowed" id="phone" value="{{ auth()->user()->phone ?? '—' }}" readonly type="text"/>
</div>
</div>
<p class="font-body-md text-label-sm text-on-surface-variant">Data pribadi diambil dari akunmu yang sedang login.</p>
</div>
<!-- Pilih Paket Keanggotaan -->
<div class="flex flex-col gap-stack-md py-stack-md border-b border-surface-container-highest border-opacity-50">
<h2 class="font-headline-md text-headline-md text-secondary">Pilih Paket Keanggotaan</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-stack-md">
<!-- Gold -->
<label class="cursor-pointer relative">
<input class="peer sr-only" name="tier" required="" type="radio" value="gold" {{ auth()->user()->membership_tier === 'gold' ? 'checked' : '' }}/>
<div class="h-full bg-amber-50 rounded-xl border-2 border-amber-300 p-stack-md flex flex-col gap-stack-sm peer-checked:border-amber-500 peer-checked:bg-amber-100 transition-all duration-300">
<div class="flex justify-between items-center">
<span class="font-headline-md text-headline-md text-amber-800">Gold</span>
<span class="material-symbols-outlined text-amber-600 opacity-0 peer-checked:opacity-100 transition-opacity">check_circle</span>
</div>
<p class="font-body-md text-body-md text-amber-900/80 text-sm">Akses standar ke semua fasilitas klub. Ideal untuk pemain rekreasional.</p>
<ul class="font-body-md text-body-md text-amber-900/80 text-sm mt-auto list-disc list-inside">
<li>Booking 2 hari sebelumnya</li>
<li>Diskon 10% di pro shop</li>
</ul>
</div>
</label>
<!-- Elite -->
<label class="cursor-pointer relative">
<input class="peer sr-only" name="tier" type="radio" value="elite" {{ auth()->user()->membership_tier === 'elite' ? 'checked' : '' }}/>
<div class="h-full bg-slate-100 rounded-xl border-2 border-slate-300 p-stack-md flex flex-col gap-stack-sm peer-checked:border-slate-500 peer-checked:bg-slate-200 transition-all duration-300">
<div class="flex justify-between items-center">
<span class="font-headline-md text-headline-md text-slate-700">Elite</span>
<span class="material-symbols-outlined text-slate-600 opacity-0 peer-checked:opacity-100 transition-opacity">check_circle</span>
</div>
<p class="font-body-md text-body-md text-slate-700/80 text-sm">Keuntungan lebih untuk pemain aktif. Akses prioritas.</p>
<ul class="font-body-md text-body-md text-slate-700/80 text-sm mt-auto list-disc list-inside">
<li>Booking 5 hari sebelumnya</li>
<li>Diskon 15% di pro shop</li>
<li>1 sesi coaching gratis/bulan</li>
</ul>
</div>
</label>
<!-- Premium -->
<label class="cursor-pointer relative">
<input class="peer sr-only" name="tier" type="radio" value="premium" {{ auth()->user()->membership_tier === 'premium' ? 'checked' : '' }}/>
<div class="h-full bg-primary-container rounded-xl border-2 border-primary-container p-stack-md flex flex-col gap-stack-sm peer-checked:border-secondary transition-all duration-300">
<div class="flex justify-between items-center">
<span class="font-headline-md text-headline-md text-on-primary-container">Premium</span>
<span class="material-symbols-outlined text-secondary opacity-0 peer-checked:opacity-100 transition-opacity">workspace_premium</span>
</div>
<p class="font-body-md text-body-md text-on-primary-container text-sm">Pengalaman eksklusif maksimal. Akses VIP tak terbatas.</p>
<ul class="font-body-md text-body-md text-on-primary-container text-sm mt-auto list-disc list-inside">
<li>Booking 14 hari sebelumnya</li>
<li>Loker VIP pribadi</li>
<li>Akses Lounge Eksklusif</li>
</ul>
</div>
</label>
</div>
</div>
<!-- Syarat & Ketentuan -->
<div class="flex flex-col gap-base pt-stack-sm">
<label class="flex items-start gap-3 cursor-pointer group">
<div class="relative flex items-center justify-center w-5 h-5 mt-0.5">
<input class="appearance-none w-5 h-5 border border-outline rounded bg-surface checked:bg-secondary checked:border-secondary transition-colors duration-200" name="terms" required="" type="checkbox"/>
<span class="material-symbols-outlined text-on-primary text-[12px] absolute pointer-events-none opacity-0 group-has-[:checked]:opacity-100 transition-opacity">check</span>
</div>
<span class="font-body-md text-body-md text-on-surface-variant text-sm">
                            Saya menyetujui <a class="text-secondary underline hover:text-tertiary transition-colors" href="{{ route('syarat-ketentuan') }}" target="_blank">Syarat &amp; Ketentuan</a> serta <a class="text-secondary underline hover:text-tertiary transition-colors" href="{{ route('kebijakan-privasi') }}" target="_blank">Kebijakan Privasi</a> Klub Padel Anggun.
                        </span>
</label>
</div>
<!-- Submit -->
<div class="pt-stack-md">
<button class="btn-animated w-full bg-secondary text-on-primary font-label-sm text-label-sm py-4 rounded-lg flex items-center justify-center gap-2 hover:bg-on-secondary-fixed-variant transition-colors duration-300 border border-transparent hover:border-tertiary group" type="submit">
                        Daftar Sekarang
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</div>
</form>
</div>
</main>
<!-- Footer -->
@endsection
