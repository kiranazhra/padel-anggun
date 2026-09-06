@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
<!-- Full Screen Background Image -->
<div class="absolute inset-0 bg-center z-0" data-alt="A beautifully composed wide-angle shot of a luxurious padel court in an exclusive boutique setting. The court is painted in a sophisticated dusty pink and vibrant forest green, illuminated by soft, natural, diffused daylight. A sleek, modern aesthetic is emphasized with pristine white lines, elegant architectural elements in the background, and a serene, high-end lifestyle mood." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD8YEAF7u6rL3d-OJYiJ6uezfqopTPBfouGsnNljHxo-I_JcRqzUZrLO19BH4gp42hmXqeUJ2jSEzGOwIY_JQUOr7JfuZtaLVZEYunesDXmSlyg9RVNS8hZsYzpRWSG53N0kGNTN0lqxJO1gc_2J9UWI_1w0uUpjy8keQeuRBZ9SC2bfmydQdF1Em85YvQq6Qqwsm8KhVv9FJmbdeJuri3Knsd5fVSYLGAIzPxb2-UrwS6LJoCmeGauLg'); background-size: 180%; background-position: center center;"></div>
<div class="absolute inset-0 bg-black/40 z-0"></div>
<!-- Central Floating Card -->
<div class="reveal w-full max-w-md bg-surface-container-lowest rounded-xl p-4 md:p-5 floating-card-shadow relative z-10">
<div class="mb-5 text-center">
    <a href="{{ route('home') }}" class="block mb-2">
    <img src="{{ asset('img/logo-padel-anggun2.png') }}" alt="Padel Anggun" class="mx-auto h-20">
  </a>
  <h1 class="font-headline-md text-headline-md text-on-surface mb-1">Bergabung dengan Komunitas Anggun</h1>
  <p class="font-body-md text-body-md text-on-surface-variant">Buat akun untuk memesan lapangan dan menikmati fasilitas keanggotaan eksklusif.</p>
</div>
@if ($errors->any())
<div class="rounded bg-error-container text-on-error-container border border-error/40 px-4 py-3 text-body-md text-body-md mb-4">
<ul class="list-disc pl-4 space-y-1">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
</div>
@endif
<form class="space-y-stack-sm w-full" method="POST" action="{{ route('register') }}">
@csrf
<!-- Nama Lengkap -->
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="fullName">Nama Lengkap</label>
<div class="relative flex items-center bg-surface-container-lowest rounded border border-outline-variant gold-glow-focus transition-colors">
<span class="material-symbols-outlined text-tertiary-fixed-dim absolute left-4" data-icon="person">person</span>
<input class="w-full bg-transparent border-none pl-11 pr-4 py-2.5 text-on-surface font-body-md focus:ring-0 placeholder-on-surface-variant/50" id="fullName" name="fullName" value="{{ old('fullName') }}" placeholder="Nama Lengkap Anda" required="" type="text">
</div>
</div>
<!-- Email -->
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="email">Email</label>
<div class="relative flex items-center bg-surface-container-lowest rounded border border-outline-variant gold-glow-focus transition-colors">
<span class="material-symbols-outlined text-tertiary-fixed-dim absolute left-4" data-icon="mail">mail</span>
<input class="w-full bg-transparent border-none pl-11 pr-4 py-2.5 text-on-surface font-body-md focus:ring-0 placeholder-on-surface-variant/50" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required="" type="email">
</div>
</div>
<!-- Nomor Telepon -->
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="phone">Nomor Telepon</label>
<div class="relative flex items-center bg-surface-container-lowest rounded border border-outline-variant gold-glow-focus transition-colors">
<span class="material-symbols-outlined text-tertiary-fixed-dim absolute left-4" data-icon="phone_iphone">phone_iphone</span>
<input class="w-full bg-transparent border-none pl-11 pr-4 py-2.5 text-on-surface font-body-md focus:ring-0 placeholder-on-surface-variant/50" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+62 812 3456 7890" required="" type="tel">
</div>
</div>
<!-- Kata Sandi -->
<div class="flex flex-col gap-base">
<label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="password">Kata Sandi</label>
<div class="relative flex items-center bg-surface-container-lowest rounded border border-outline-variant gold-glow-focus transition-colors">
<span class="material-symbols-outlined text-tertiary-fixed-dim absolute left-4" data-icon="lock">lock</span>
<input class="w-full bg-transparent border-none pl-11 pr-11 py-2.5 text-on-surface font-body-md focus:ring-0 placeholder-on-surface-variant/50" id="password" name="password" placeholder="Minimal 8 karakter" required="" type="password">
<button aria-label="Toggle password visibility" class="pa-toggle-password absolute right-4 text-outline hover:text-secondary transition-colors" type="button" data-target="password">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</div>
<!-- Syarat & Ketentuan Checkbox -->
<div class="flex items-start gap-3 pt-1 pb-2">
<div class="flex items-center h-6">
<input class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-tertiary-fixed-dim bg-surface-container-lowest cursor-pointer" id="terms" name="terms" required="" type="checkbox">
</div>
<label class="font-body-md text-body-md text-on-surface-variant cursor-pointer" for="terms">
                Saya menyetujui <a class="text-secondary font-medium hover:underline decoration-tertiary-fixed-dim underline-offset-4" href="#">Syarat &amp; Ketentuan</a> serta <a class="text-secondary font-medium hover:underline decoration-tertiary-fixed-dim underline-offset-4" href="#">Kebijakan Privasi</a>.
            </label>
</div>
<!-- Submit Button -->
<button class="btn-animated w-full bg-secondary text-on-secondary py-3 rounded-lg font-label-sm text-label-sm uppercase tracking-widest hover:bg-on-secondary-fixed-variant transition-colors flex justify-center items-center gap-2 ambient-shadow min-h-[44px]" type="submit">
<span class="">Buat Akun</span>
<span class="material-symbols-outlined icon-fill text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</form>
<!-- Login Link -->
<div class="mt-5 text-center w-full">
<p class="font-body-md text-body-md text-on-surface-variant">
            Sudah punya akun? 
            <a class="text-secondary font-semibold hover:text-tertiary-fixed-dim transition-colors ml-1" href="{{ route('login') }}">Masuk</a>
</p>
</div>
</div>

<script>
  document.querySelectorAll('.pa-toggle-password').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = document.getElementById(btn.getAttribute('data-target'));
      var icon = btn.querySelector('.material-symbols-outlined');
      if (!input) return;
      var isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.textContent = isHidden ? 'visibility_off' : 'visibility';
    });
  });
</script>
@endsection
