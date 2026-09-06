@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<!-- Background Image -->
<div class="absolute inset-0 bg-cover bg-center w-full h-full z-0" data-alt="A luxurious padel club court at twilight, bathed in warm, golden artificial lighting. The court features premium glass walls and deep green astroturf. In the background, elegant lounge areas with comfortable seating are visible. The atmosphere is exclusive, serene, and sophisticated, perfectly capturing a high-end country club aesthetic." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCmhx-NKxbJIEOioz8Icj3LYQPW5tF_qYT4H3AYxXwxJeQiK_aTSOB3bXVs2pUI3TxxHfN-ripjLD5KFDzkNzz5b_le1Vx6q2wHT4aBWKI9UIrwMASsaBO8jioZEfnM3MhNl8HEq5NOdW-E5cbraea52ENKPZNJuLAr9EqkW64VYO7yS383GVkLyw5EyIlObqQ30ZSCQSJUvhLzj_2MPJ5N1XoNr48Yh_at6GVmUaW3RxeCd9AuW83dFw')"></div>
<!-- Overlay for atmosphere -->
<div class="absolute inset-0 bg-black/60 mix-blend-multiply z-0"></div>
<!-- Central Floating Card -->
<div class="reveal relative w-full max-w-md bg-surface-container-lowest rounded-lg shadow-xl p-5 space-y-stack-lg z-10">
<!-- Header -->
<div class="text-center space-y-stack-sm">
    <a href="{{ route('home') }}" class="block mb-2">
        <img src="{{ asset('img/logo-padel-anggun2.png') }}" alt="Padel Anggun" class="mx-auto h-20">
    </a>
    <h2 class="font-headline-md text-headline-md text-on-surface mt-stack-md">Selamat Datang Kembali</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Masuk untuk melanjutkan ke akun Anda.</p>
</div>
@if ($errors->any())
<div class="rounded-DEFAULT bg-error-container text-on-error-container border border-error/40 px-4 py-3 text-body-md text-body-md">
<ul class="list-disc pl-4 space-y-1">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
</div>
@endif
<!-- Form -->
<form class="space-y-stack-md" method="POST" action="{{ route('login') }}">
@csrf
<!-- Email Field -->
<div class="space-y-base">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="email">Alamat Email</label>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface placeholder-on-surface-variant/50" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" type="email" required autofocus>
</div>
<!-- Password Field -->
<div class="space-y-base">
<div class="flex justify-between items-center">
<label class="font-label-sm text-label-sm text-on-surface-variant block" for="password">Kata Sandi</label>
<a class="font-label-sm text-label-sm text-tertiary-fixed-dim hover:text-tertiary-container transition-colors" href="#">Lupa Kata Sandi?</a>
</div>
<input class="w-full px-4 py-3 bg-surface border border-primary-fixed-dim rounded-DEFAULT focus:outline-none focus:border-secondary focus:ring-1 focus:ring-tertiary transition-colors gold-focus font-body-md text-body-md text-on-surface placeholder-on-surface-variant/50" id="password" name="password" placeholder="••••••••" type="password" required>
</div>
<!-- Remember Me -->
<div class="flex items-center gap-2 mt-stack-sm">
<input class="w-4 h-4 rounded text-secondary border-primary-fixed-dim focus:ring-secondary bg-surface cursor-pointer" id="remember" name="remember" type="checkbox">
<label class="font-body-md text-body-md text-on-surface-variant cursor-pointer" for="remember">Ingat saya</label>
</div>
<!-- Submit Button -->
<button class="btn-animated w-full h-12 mt-stack-lg bg-secondary text-on-secondary font-label-md text-label-md uppercase tracking-wider rounded-DEFAULT hover:bg-on-secondary-fixed-variant transition-colors flex items-center justify-center gap-2 group" type="submit">
                        Masuk
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</form>
<!-- Divider -->
<div class="relative flex items-center py-stack-md">
<div class="flex-grow border-t border-tertiary-fixed-dim/30"></div>
<span class="flex-shrink-0 mx-4 text-on-surface-variant font-label-sm text-label-sm">ATAU</span>
<div class="flex-grow border-t border-tertiary-fixed-dim/30"></div>
</div>
<!-- Sign Up Link -->
<p class="text-center font-body-md text-body-md text-on-surface-variant">
                    Belum punya akun? 
                    <a class="text-secondary font-bold hover:underline" href="{{ route('register') }}">Daftar Sekarang</a>
</p>
</div>
@endsection
