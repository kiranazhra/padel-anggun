@extends('layouts.admin')

@section('title', 'Pengaturan Promo')

@section('content')
<!-- Main Content Area -->
<div class="flex-1 md:ml-72 flex flex-col min-h-screen">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Pengaturan', 'titleAccent' => 'Promo'])
<!-- Canvas -->
<main class="flex-1 bg-surface-container-lowest p-container-margin md:p-section-gap">

@if (session('status'))
<div class="mb-stack-lg bg-secondary-container text-on-secondary-container border border-secondary/30 rounded-lg px-4 py-3 flex items-center gap-3">
    <span class="material-symbols-outlined">check_circle</span>
    <span class="font-body-md text-body-md">{{ session('status') }}</span>
</div>
@endif

@if ($errors->any())
<div class="mb-stack-lg bg-error-container text-on-error-container border border-error/40 rounded-lg px-4 py-3">
    <ul class="list-disc pl-4 text-body-md">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="flex justify-between items-end mb-stack-lg pb-stack-sm border-b border-tertiary-fixed-dim/20">
<div>
<h3 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Daftar Promo</h3>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Kelola penawaran khusus dan diskon untuk anggota Klub Padel Anggun. Promo yang berstatus aktif akan langsung terlihat di aplikasi pelanggan.</p>
</div>
<button type="button" onclick="document.getElementById('tambah-promo-form').classList.toggle('hidden')" class="bg-secondary text-on-secondary font-label-sm text-label-sm py-3 px-6 rounded-lg hover:bg-on-secondary-fixed-variant transition-colors flex items-center gap-2 h-12 shadow-[0px_4px_20px_rgba(27,48,34,0.06)]">
<span class="material-symbols-outlined">add</span>
                    Tambah Promo Baru
                </button>
</div>

<!-- Form Tambah Promo -->
<div id="tambah-promo-form" class="hidden bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/30 mb-stack-lg">
<p class="font-label-sm text-label-sm text-outline mb-3 uppercase tracking-widest">Tambah Promo Baru</p>
<form method="POST" action="{{ route('admin.promo.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
@csrf
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Judul Promo</label>
<input type="text" name="title" required maxlength="100" placeholder="cth. Diskon Pagi Hari" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Nilai</label>
<input type="text" name="discount_value" required maxlength="30" placeholder="cth. 20% / Rp 50rb" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Label</label>
<input type="text" name="discount_label" maxlength="30" placeholder="cth. Off / Kredit" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Berlaku Hingga</label>
<input type="date" name="valid_until" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan
</button>
</div>
<div class="md:col-span-6">
<label class="block font-label-sm text-label-sm text-outline mb-1">Deskripsi</label>
<input type="text" name="description" maxlength="500" placeholder="cth. Berlaku untuk pemesanan lapangan antara pukul 06:00 - 09:00 WIB." class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
</form>
</div>

@if ($promos->isEmpty())
<div class="bg-surface-container-lowest rounded-xl p-12 text-center text-on-surface-variant border border-outline-variant/30">
    Belum ada promo. Tambahkan promo pertama lewat tombol di atas.
</div>
@else
<!-- Bento Grid / Cards Layout -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-stack-lg">
@foreach ($promos as $promo)
<div class="bg-surface rounded-xl p-5 border border-outline-variant/30 shadow-[0px_4px_20px_rgba(27,48,34,0.04)] hover:shadow-[0px_8px_30px_rgba(27,48,34,0.08)] hover:border-tertiary/40 transition-all duration-300 flex flex-col group relative overflow-hidden {{ ! $promo->is_active ? 'opacity-75' : '' }}">
<div class="flex justify-between items-start mb-4 relative z-10">
<div class="w-12 h-12 rounded-full bg-surface flex items-center justify-center text-secondary border border-outline-variant/20">
<span class="material-symbols-outlined">{{ $promo->icon ?: 'sell' }}</span>
</div>
@if ($promo->is_active)
<span class="px-3 py-1 bg-secondary/10 text-secondary font-label-sm text-label-sm rounded-full border border-secondary/20">Aktif</span>
@else
<span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm text-label-sm rounded-full border border-outline-variant/50">Non-Aktif</span>
@endif
</div>
<div class="relative z-10 flex-1">
<h4 class="font-headline-md text-headline-md text-on-surface mb-1">{{ $promo->title }}</h4>
<div class="text-display-lg font-display-lg text-tertiary mb-2">{{ $promo->discount_value }} <span class="font-body-md text-body-md text-on-surface-variant font-normal">{{ $promo->discount_label ?: 'Off' }}</span></div>
@if ($promo->description)
<p class="font-body-md text-body-md text-on-surface-variant mb-6">{{ $promo->description }}</p>
@endif
</div>
<div class="mt-auto border-t border-outline-variant/20 pt-4 flex justify-between items-center relative z-10">
<div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
@if ($promo->valid_until)
<span class="material-symbols-outlined text-[12px]">{{ $promo->is_expired ? 'history' : 'schedule' }}</span>
{{ $promo->is_expired ? 'Berakhir' : 'Hingga' }} {{ $promo->valid_until->translatedFormat('d M Y') }}
@else
<span class="material-symbols-outlined text-[12px]">all_inclusive</span>
Tanpa Batas
@endif
</div>
<div class="flex items-center gap-2">
<button type="button" onclick="document.getElementById('edit-promo-{{ $promo->id }}').classList.toggle('hidden')" class="text-secondary hover:text-tertiary font-label-sm text-label-sm underline">Edit</button>
<form method="POST" action="{{ route('admin.promo.toggle-aktif', $promo) }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="p-1 rounded-lg border border-outline-variant/50 hover:border-tertiary/50 transition-colors" title="{{ $promo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
        <span class="material-symbols-outlined text-[15px]">{{ $promo->is_active ? 'visibility_off' : 'visibility' }}</span>
    </button>
</form>
<form method="POST" action="{{ route('admin.promo.destroy', $promo) }}" onsubmit="return confirm('Hapus promo {{ $promo->title }}?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="p-1 rounded-lg border border-outline-variant/50 hover:border-error/50 hover:text-error transition-colors" title="Hapus promo">
        <span class="material-symbols-outlined text-[15px]">delete</span>
    </button>
</form>
</div>
</div>
</div>
@endforeach
</div>

<!-- Form Edit (di luar grid supaya lebar penuh) -->
@foreach ($promos as $promo)
<div id="edit-promo-{{ $promo->id }}" class="hidden bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/30 mt-stack-md">
<p class="font-label-sm text-label-sm text-outline mb-3 uppercase tracking-widest">Edit Promo: {{ $promo->title }}</p>
<form method="POST" action="{{ route('admin.promo.update', $promo) }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
@csrf
@method('PUT')
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Judul Promo</label>
<input type="text" name="title" required maxlength="100" value="{{ $promo->title }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Nilai</label>
<input type="text" name="discount_value" required maxlength="30" value="{{ $promo->discount_value }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Label</label>
<input type="text" name="discount_label" maxlength="30" value="{{ $promo->discount_label }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Berlaku Hingga</label>
<input type="date" name="valid_until" value="{{ optional($promo->valid_until)->toDateString() }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-1">
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan
</button>
</div>
<div class="md:col-span-6">
<label class="block font-label-sm text-label-sm text-outline mb-1">Deskripsi</label>
<input type="text" name="description" maxlength="500" value="{{ $promo->description }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
</form>
</div>
@endforeach
@endif
</main>
</div>
@endsection
