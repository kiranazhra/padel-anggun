@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<main class="flex-grow px-container-margin py-section-gap max-w-[720px] mx-auto w-full">

@if (session('status'))
<div class="reveal mb-stack-lg bg-secondary-container text-on-secondary-container border border-secondary/30 rounded-lg px-stack-md py-4 flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-body-md text-body-md">{{ session('status') }}</span>
</div>
@endif

@if ($errors->any())
<div class="mb-stack-lg bg-error-container text-on-error-container border border-error/40 rounded-lg px-stack-md py-4">
    <ul class="list-disc pl-4 space-y-1 text-body-md">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<header class="mb-stack-lg flex items-center gap-4">
<div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center shrink-0">
<span class="font-headline-lg text-headline-lg text-on-secondary-container">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
</div>
<div>
<h1 class="font-headline-lg text-headline-lg text-secondary">Profil <span class="gold-text">Saya</span></h1>
<p class="font-body-md text-body-md text-on-surface-variant">Kelola data akun {{ $user->name }}.</p>
</div>
</header>

<div class="bg-surface-container-lowest rounded-xl elegant-shadow border border-outline-variant/20 p-5 md:p-stack-lg">
<form method="POST" action="{{ route('profile.update') }}" class="space-y-stack-md">
@csrf
@method('PUT')

<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="name">Nama Lengkap</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="name" name="name" value="{{ old('name', $user->name) }}" required>
</div>

<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="email">Alamat Email</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
</div>

<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="phone">Nomor Telepon</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="cth. 0812xxxxxxx">
</div>

<div class="w-full h-px bg-tertiary/10 my-stack-sm"></div>

<p class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Ganti Kata Sandi (opsional)</p>

<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="current_password">Kata Sandi Saat Ini</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="current_password" name="current_password" type="password" placeholder="Isi kalau ingin mengganti kata sandi" autocomplete="current-password">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="password">Kata Sandi Baru</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="password" name="password" type="password" autocomplete="new-password">
</div>
<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
</div>
</div>

<div class="flex justify-end pt-stack-sm">
<button class="btn-animated bg-secondary text-on-secondary font-label-sm text-label-sm h-12 px-8 rounded-DEFAULT hover:bg-secondary/90 transition-colors" type="submit">
    Simpan Perubahan
</button>
</div>
</form>
</div>
</main>
@endsection
