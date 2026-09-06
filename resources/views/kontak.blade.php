@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<!-- Main Content -->
<main class="px-container-margin py-section-gap max-w-7xl mx-auto w-full">
<!-- Hero -->
<header class="reveal text-center mb-section-gap">
<h1 class="font-display-lg text-display-lg text-secondary mb-stack-md">Hubungi Kami</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">Kami siap mendengarkan. Silakan hubungi kami untuk pertanyaan, reservasi, atau sekadar berbagi cerita padel Anda.</p>
</header>
<!-- Bento Grid Contact & Form -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-stack-lg mb-section-gap">
<!-- Informasi Kontak -->
<section class="reveal reveal-delay-1 rounded-xl p-4 soft-shadow border border-outline-variant/30 flex flex-col justify-between bg-primary-container">
<div>
<h2 class="font-headline-md text-headline-md text-primary mb-stack-sm">Informasi Kontak</h2>
<div class="space-y-stack-sm mb-stack-sm">
<div class="flex items-start">
<span class="material-symbols-outlined text-tertiary mr-4 mt-1" style="font-variation-settings: 'FILL' 1;">location_on</span>
<div>
<h3 class="font-label-sm text-label-sm uppercase text-outline mb-1">Alamat</h3>
<p class="font-body-md text-body-md text-on-surface">Jl. Padel Anggun No. 88, Senayan<br>Jakarta Selatan, 12190</p>
</div>
</div>
<div class="flex items-start">
<span class="material-symbols-outlined text-tertiary mr-4 mt-1" style="font-variation-settings: 'FILL' 1;">call</span>
<div>
<h3 class="font-label-sm text-label-sm uppercase text-outline mb-1">Telepon / WhatsApp</h3>
<p class="font-body-md text-body-md text-on-surface">+62 811-9988-7766</p>
</div>
</div>
<div class="flex items-start">
<span class="material-symbols-outlined text-tertiary mr-4 mt-1" style="font-variation-settings: 'FILL' 1;">mail</span>
<div>
<h3 class="font-label-sm text-label-sm uppercase text-outline mb-1">Email</h3>
<p class="font-body-md text-body-md text-on-surface">halo@padelanggun.com</p>
</div>
</div>
<div class="flex items-start">
<span class="material-symbols-outlined text-tertiary mr-4 mt-1" style="font-variation-settings: 'FILL' 1;">schedule</span>
<div>
<h3 class="font-label-sm text-label-sm uppercase text-outline mb-1">Jam Operasional</h3>
<p class="font-body-md text-body-md text-on-surface">Senin - Jumat: 06:00 - 22:00<br>Sabtu - Minggu: 07:00 - 20:00</p>
</div>
</div>
</div>
</div>
<div>
<div class="h-px w-full bg-tertiary-fixed-dim/30 mb-stack-sm"></div>
<h3 class="font-label-sm text-label-sm uppercase text-outline mb-stack-sm">Ikuti Kami</h3>
<div class="flex space-x-4">
<a class="w-10 h-10 rounded-full border border-secondary/30 bg-secondary-container/30 flex items-center justify-center text-secondary hover:bg-secondary-container hover:text-on-secondary-container hover:border-secondary transition-all duration-300" href="#" aria-label="WhatsApp">
<svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
</a>
<a class="w-10 h-10 rounded-full border border-secondary/30 bg-secondary-container/30 flex items-center justify-center text-secondary hover:bg-secondary-container hover:text-on-secondary-container hover:border-secondary transition-all duration-300" href="#" aria-label="Instagram">
<svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
</a>
<a class="w-10 h-10 rounded-full border border-secondary/30 bg-secondary-container/30 flex items-center justify-center text-secondary hover:bg-secondary-container hover:text-on-secondary-container hover:border-secondary transition-all duration-300" href="#" aria-label="TikTok">
<svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.59-1.01-.01 2.62.02 5.24-.02 7.86-.03 1.17-.36 2.35-.9 3.39-.88 1.71-2.51 2.91-4.44 3.28-1.43.27-2.93.14-4.26-.43-1.5-.65-2.64-1.88-3.13-3.43-.46-1.42-.36-3.06.35-4.42.79-1.56 2.45-2.63 4.23-2.69.16-.01.32-.01.48 0v4.08c-.59.1-1.15.33-1.62.7-.69.54-1.02 1.41-.92 2.28.1 1.13.98 2.13 2.1 2.31 1.08.17 2.26-.39 2.69-1.39.17-.4.22-.82.21-1.25-.01-4.4-.03-8.81-.03-13.21z"></path></svg>
</a>
</div>
</div>
</section>
<!-- Kritik & Saran Form -->
<section class="reveal reveal-delay-2 bg-surface-container-lowest rounded-xl p-4 soft-shadow border border-outline-variant/50">
<h2 class="font-headline-md text-headline-md text-secondary mb-1">Kritik &amp; Saran</h2>
<p class="font-body-md text-body-md text-on-surface-variant mb-stack-sm">Masukan Anda sangat berharga untuk meningkatkan kualitas layanan butik kami.</p>
<form class="space-y-stack-sm">
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-1" for="name">Nama Lengkap</label>
<input class="w-full bg-surface-container-lowest border border-primary-fixed-dim rounded-lg px-4 py-2.5 font-body-md text-on-surface focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors" id="name" name="name" placeholder="Masukkan nama Anda" type="text">
</div>
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-1" for="cemail">Alamat Email</label>
<input class="w-full bg-surface-container-lowest border border-primary-fixed-dim rounded-lg px-4 py-2.5 font-body-md text-on-surface focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors" id="cemail" name="email" placeholder="nama@email.com" type="email">
</div>
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-1" for="message">Pesan</label>
<textarea class="w-full bg-surface-container-lowest border border-primary-fixed-dim rounded-lg px-4 py-3 font-body-md text-on-surface focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary transition-colors resize-none" id="message" name="message" placeholder="Tuliskan pesan Anda di sini..." rows="3"></textarea>
</div>
<button class="btn-animated w-full bg-secondary text-on-secondary h-11 rounded-lg font-label-sm text-label-sm uppercase tracking-widest hover:bg-on-secondary-fixed-variant transition-colors active:scale-[0.98] shadow-sm flex items-center justify-center space-x-2 mt-stack-md" type="submit">
<span>Kirim Pesan</span>
<span class="material-symbols-outlined text-[15px]">send</span>
</button>
</form>
</section>
</div>
<!-- Map -->
<section class="reveal reveal-delay-3 w-full rounded-xl overflow-hidden soft-shadow h-96 relative border border-outline-variant/30">
<iframe
    src="https://www.google.com/maps?q=Senayan,+Jakarta+Selatan&output=embed"
    class="absolute inset-0 w-full h-full border-0"
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    title="Peta Lokasi Klub Padel Anggun">
</iframe>
<div class="absolute bottom-5 left-5 bg-surface-container-lowest/90 backdrop-blur-sm p-4 rounded-lg shadow-sm border border-outline-variant/20 flex items-center space-x-4 pointer-events-none">
<div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-container">map</span>
</div>
<div class="pointer-events-auto">
<h4 class="font-headline-md text-headline-md text-secondary text-[17px]">Klub Padel Anggun</h4>
<a class="font-label-sm text-label-sm text-tertiary hover:underline uppercase tracking-wide" href="https://www.google.com/maps?q=Senayan,+Jakarta+Selatan" target="_blank" rel="noopener">Buka di Maps</a>
</div>
</div>
</section>
</main>
<!-- Footer -->
@endsection
