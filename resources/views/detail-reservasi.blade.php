@extends('layouts.app')

@section('title', $court['nama'])

@section('content')
<main class="max-w-[1200px] mx-auto px-container-margin py-section-gap">
<!-- Gallery Header -->
<section class="mb-section-gap">
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 h-[300px] md:h-[380px] rounded-xl overflow-hidden">
<div class="md:col-span-3 h-full relative group">
<img alt="{{ $court['nama'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $court['gambar_utama'] }}">
<div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/40 to-transparent"></div>
</div>
<div class="hidden md:flex flex-col gap-4 h-full">
<div class="h-[calc(50%-8px)] relative group overflow-hidden rounded-r-xl">
<img alt="Fasilitas Shower" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB9gWQp4BwMiAQcd6Q02np8X3TOHs81V2LMnQILWZuXXiOdRukO3M37JIfbMfggHsx8DoTn4qmrLDv1P436FqYFCWY20Jrs5DMBy4T3Msm_xPCAO4W1nmQ_MAWJmNiUkiOaEkX6Ss-38gnRetbSVuw1BxEd9TcMJh9mRULlk1wa1nf-PZj1aMJ7r7_Vk7K_VCFu_UnzAer4770Nd45NODTI9uCfQKn2UaGphFpjr-UfNC9m82Om4FWj2w">
</div>
<div class="h-[calc(50%-8px)] relative group overflow-hidden rounded-r-xl">
<img alt="Kafe Clubhouse" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuACi0_G86QuAdmStIzxODIvwyOvxpIIzmQDGAcMEL30B4wJqJ-9dhXHocACx3HIeTrabjs6y3MU5GBOGhyEhY7XpCvhmF170uAgfxoOhnJyRK5c0s21drhAc3bFkBjWND-xNBkTMcHh_ER-lnZRuz1Kj9H_ObN9sq5edghqmBiJNFUmZ1S1UsczT2aARHFCKx0iJa4p_pwlUmNpds6FSNLROP_uYThxZRKlW8sKiNgPegCTYVH0hzLMOg">
</div>
</div>
</div>
</section>
<!-- Content Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-section-gap">
<!-- Left Column: Details -->
<div class="lg:col-span-7 space-y-stack-lg">
<div>
<div class="flex items-center gap-3 mb-2">
<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-sm text-label-sm uppercase">Tersedia</span>
<span class="text-outline text-label-sm font-label-sm flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">location_on</span> {{ $court['tipe'] }}</span>
</div>
<h1 class="reveal font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4">{{ $court['nama'] }}</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">
    {{ $court['deskripsi'] }}
</p>
</div>
<div class="h-px bg-tertiary-fixed/30 w-full"></div>
<div>
<h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Fasilitas Termasuk</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-stack-md">
<div class="flex items-start gap-4 p-4 rounded-lg bg-surface-bright border border-outline-variant/30 hover:border-tertiary/50 transition-colors">
<div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
<span class="material-symbols-outlined">storefront</span>
</div>
<div>
<h4 class="font-label-sm text-label-sm text-on-surface mb-1">Akses Pro Shop</h4>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Peralatan kelas atas dan apparel eksklusif.</p>
</div>
</div>
<div class="flex items-start gap-4 p-4 rounded-lg bg-surface-bright border border-outline-variant/30 hover:border-tertiary/50 transition-colors">
<div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
<span class="material-symbols-outlined">shower</span>
</div>
<div>
<h4 class="font-label-sm text-label-sm text-on-surface mb-1">Shower Mewah</h4>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Fasilitas bilas dengan perlengkapan mandi premium.</p>
</div>
</div>
<div class="flex items-start gap-4 p-4 rounded-lg bg-surface-bright border border-outline-variant/30 hover:border-tertiary/50 transition-colors">
<div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
<span class="material-symbols-outlined">local_cafe</span>
</div>
<div>
<h4 class="font-label-sm text-label-sm text-on-surface mb-1">Kafe Clubhouse</h4>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Nikmati hidangan sehat dan kopi artisan paska bermain.</p>
</div>
</div>
<div class="flex items-start gap-4 p-4 rounded-lg bg-surface-bright border border-outline-variant/30 hover:border-tertiary/50 transition-colors">
<div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-fixed">
<span class="material-symbols-outlined">wifi</span>
</div>
<div>
<h4 class="font-label-sm text-label-sm text-on-surface mb-1">Wi-Fi Berkecepatan Tinggi</h4>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Konektivitas tanpa batas di seluruh area.</p>
</div>
</div>
</div>
</div>
</div>
<!-- Right Column: Booking Widget -->
<div class="lg:col-span-5">
<div class="reveal card-hover-lift sticky top-[100px] bg-surface-container-lowest rounded-xl p-container-margin shadow-[0px_4px_20px_rgba(27,48,34,0.06)] border border-primary-container/50">
<h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md text-center">Reservasi Lapangan</h3>

<form method="POST" action="{{ route('reservasi.store', $court['id']) }}" id="reservasi-form" class="space-y-stack-md">
@csrf
<input type="hidden" name="tanggal" id="input-tanggal" value="{{ $dates[0]['iso'] }}">
<input type="hidden" name="waktu" id="input-waktu" value="{{ collect($court['slot'])->first(fn($s) => !in_array($s, $court['slot_penuh'])) }}">
<input type="hidden" name="coach_id" id="input-coach" value="">

<!-- Date Selection -->
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest">Pilih Tanggal</label>
<div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="date-picker">
@foreach ($dates as $i => $d)
<button type="button" data-date="{{ $d['iso'] }}"
    class="pa-date-btn flex-shrink-0 w-16 py-3 rounded-lg border flex flex-col items-center justify-center transition-colors {{ $i === 0 ? 'border-tertiary bg-surface-bright text-tertiary' : 'border-outline-variant/50 bg-surface-bright hover:border-tertiary/50 text-on-surface-variant' }}">
    <span class="text-xs uppercase">{{ $d['hari'] }}</span>
    <span class="font-headline-md text-lg">{{ $d['tanggal'] }}</span>
</button>
@endforeach
</div>
</div>

<!-- Time Selection -->
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest">Pilih Waktu</label>
<div class="grid grid-cols-3 gap-2" id="time-picker">
@php $firstAvailable = collect($court['slot'])->first(fn($s) => !in_array($s, $court['slot_penuh'])); @endphp
@foreach ($court['slot'] as $jam)
    @if (in_array($jam, $court['slot_penuh']))
    <button type="button" disabled class="py-2 border border-outline-variant/50 rounded-lg text-sm font-medium opacity-50 cursor-not-allowed bg-surface-container-high relative overflow-hidden">
        <span class="relative z-10">{{ $jam }}</span>
        <div class="absolute inset-0 bg-surface-variant/50 transform -skew-x-12"></div>
    </button>
    @else
    <button type="button" data-time="{{ $jam }}"
        class="pa-time-btn py-2 border rounded-lg text-sm font-medium transition-colors {{ $jam === $firstAvailable ? 'border-tertiary bg-tertiary/5 text-tertiary' : 'border-outline-variant/50 hover:border-tertiary/50' }}">{{ $jam }}</button>
    @endif
@endforeach
</div>
</div>

<!-- Coach Selection -->
<div>
<label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 uppercase tracking-widest">Pilih Pelatih (Opsional)</label>
<div class="flex flex-col gap-2" id="coach-picker">
<button type="button" data-coach-id="" data-coach-fee="0"
    class="pa-coach-btn w-full text-left px-4 py-3 rounded-lg border transition-colors border-tertiary bg-surface-bright text-tertiary flex items-center justify-between">
    <span>
        <span class="block font-label-sm text-label-sm">Tanpa Pelatih</span>
        <span class="block text-xs text-on-surface-variant">Main tanpa pendampingan pelatih</span>
    </span>
    <span class="material-symbols-outlined text-[18px] pa-coach-check">check_circle</span>
</button>
@forelse ($coaches as $coach)
<button type="button" data-coach-id="{{ $coach->id }}" data-coach-fee="{{ $coach->fee }}"
    class="pa-coach-btn w-full text-left px-4 py-3 rounded-lg border transition-colors border-outline-variant/50 bg-surface-bright hover:border-tertiary/50 text-on-surface-variant flex items-center justify-between">
    <span>
        <span class="block font-label-sm text-label-sm text-on-surface">{{ $coach->name }}</span>
        <span class="block text-xs text-on-surface-variant">{{ $coach->specialty ?? 'Pelatih Padel' }} &middot; Rp {{ number_format($coach->fee, 0, ',', '.') }}</span>
    </span>
    <span class="material-symbols-outlined text-[18px] pa-coach-check opacity-0">check_circle</span>
</button>
@empty
<p class="text-xs text-on-surface-variant">Belum ada pelatih aktif saat ini.</p>
@endforelse
</div>
</div>

<div class="h-px bg-tertiary-fixed/30 w-full my-4"></div>

<!-- Price Breakdown -->
<div class="space-y-2 font-body-md text-body-md">
<div class="flex justify-between text-on-surface-variant">
<span>Biaya Lapangan (90 Menit)</span>
<span>Rp {{ number_format($court['harga'], 0, ',', '.') }}</span>
</div>
<div class="flex justify-between text-on-surface-variant">
<span>Surcharge Jam Sibuk</span>
<span>Rp 50.000</span>
</div>
<div class="flex justify-between text-on-surface-variant" id="coach-fee-row" style="display:none;">
<span id="coach-fee-label">Biaya Pelatih</span>
<span id="coach-fee-value">Rp 0</span>
</div>
<div class="flex justify-between font-headline-md text-lg text-on-surface pt-2 border-t border-outline-variant/20 mt-2">
<span>Total</span>
<span class="text-secondary" id="total-harga">Rp {{ number_format($court['harga'] + 50000, 0, ',', '.') }}</span>
</div>
</div>

<button type="submit" class="btn-animated w-full mt-6 bg-secondary text-on-secondary py-4 rounded-lg font-label-sm text-label-sm uppercase tracking-wider hover:bg-secondary/90 transition-colors shadow-sm relative overflow-hidden group">
<span class="relative z-10">Konfirmasi Reservasi</span>
<div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
</button>
<p class="text-center text-xs text-on-surface-variant mt-3">Pembatalan gratis hingga 24 jam sebelum jadwal.</p>
</form>
</div>
</div>
</div>
</main>

<script>
(function () {
    var dateButtons = document.querySelectorAll('.pa-date-btn');
    var timeButtons = document.querySelectorAll('.pa-time-btn');
    var coachButtons = document.querySelectorAll('.pa-coach-btn');
    var inputTanggal = document.getElementById('input-tanggal');
    var inputWaktu = document.getElementById('input-waktu');
    var inputCoach = document.getElementById('input-coach');

    var basePrice = {{ $court['harga'] }};
    var surcharge = 50000;
    var totalEl = document.getElementById('total-harga');
    var coachFeeRow = document.getElementById('coach-fee-row');
    var coachFeeValue = document.getElementById('coach-fee-value');

    function formatRupiah(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function recalcTotal() {
        var fee = parseInt(inputCoach.value ? (document.querySelector('.pa-coach-btn[data-coach-id="' + inputCoach.value + '"]') || {}).getAttribute('data-coach-fee') || 0 : 0, 10) || 0;

        if (fee > 0) {
            coachFeeRow.style.display = 'flex';
            coachFeeValue.textContent = formatRupiah(fee);
        } else {
            coachFeeRow.style.display = 'none';
        }

        totalEl.textContent = formatRupiah(basePrice + surcharge + fee);
    }

    var coachActiveClasses = ['border-tertiary', 'bg-surface-bright', 'text-tertiary'];
    var coachInactiveClasses = ['border-outline-variant/50', 'bg-surface-bright', 'hover:border-tertiary/50', 'text-on-surface-variant'];

    coachButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            coachButtons.forEach(function (b) {
                b.classList.remove('border-tertiary', 'text-tertiary');
                b.classList.add('border-outline-variant/50', 'hover:border-tertiary/50');
                var check = b.querySelector('.pa-coach-check');
                if (check) check.classList.add('opacity-0');
            });
            this.classList.add('border-tertiary', 'text-tertiary');
            this.classList.remove('border-outline-variant/50', 'hover:border-tertiary/50');
            var check = this.querySelector('.pa-coach-check');
            if (check) check.classList.remove('opacity-0');
            inputCoach.value = this.getAttribute('data-coach-id');
            recalcTotal();
        });
    });

    var activeClasses = ['border-tertiary', 'bg-surface-bright', 'text-tertiary'];
    var inactiveClasses = ['border-outline-variant/50', 'bg-surface-bright', 'hover:border-tertiary/50', 'text-on-surface-variant'];

    dateButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            dateButtons.forEach(function (b) {
                b.classList.remove('border-tertiary', 'bg-surface-bright', 'text-tertiary');
                b.classList.add('border-outline-variant/50', 'hover:border-tertiary/50', 'text-on-surface-variant');
            });
            this.classList.add('border-tertiary', 'bg-surface-bright', 'text-tertiary');
            this.classList.remove('border-outline-variant/50', 'hover:border-tertiary/50', 'text-on-surface-variant');
            inputTanggal.value = this.getAttribute('data-date');
        });
    });

    var timeActiveClasses = ['border-tertiary', 'bg-tertiary/5', 'text-tertiary'];
    var timeInactiveClasses = ['border-outline-variant/50', 'hover:border-tertiary/50'];

    timeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            timeButtons.forEach(function (b) {
                b.classList.remove('border-tertiary', 'bg-tertiary/5', 'text-tertiary');
                b.classList.add('border-outline-variant/50', 'hover:border-tertiary/50');
            });
            this.classList.add('border-tertiary', 'bg-tertiary/5', 'text-tertiary');
            this.classList.remove('border-outline-variant/50', 'hover:border-tertiary/50');
            inputWaktu.value = this.getAttribute('data-time');
        });
    });
})();
</script>
@endsection
