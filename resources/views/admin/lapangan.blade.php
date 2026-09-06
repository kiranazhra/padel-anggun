@extends('layouts.admin')

@section('title', 'Kelola Lapangan')

@section('content')
<!-- Main Content Area -->
<div class="flex-1 md:ml-72 flex flex-col min-h-screen">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Kelola', 'titleAccent' => 'Lapangan'])
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
<h3 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Daftar Lapangan</h3>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Kelola data lapangan, harga sewa per jam, dan status operasional harian. Lapangan yang aktif akan muncul di halaman pemesanan pelanggan.</p>
</div>
<button type="button" onclick="document.getElementById('tambah-lapangan-form').classList.toggle('hidden')" class="bg-secondary text-on-secondary font-label-sm text-label-sm py-3 px-6 rounded-lg hover:bg-on-secondary-fixed-variant transition-colors flex items-center gap-2 h-12 shadow-[0px_4px_20px_rgba(27,48,34,0.06)]">
<span class="material-symbols-outlined">add</span>
                    Tambah Lapangan Baru
                </button>
</div>

<!-- Form Tambah Lapangan -->
<div id="tambah-lapangan-form" class="hidden bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/30 mb-stack-lg">
<p class="font-label-sm text-label-sm text-outline mb-3 uppercase tracking-widest">Tambah Lapangan Baru</p>
<form method="POST" action="{{ route('admin.lapangan.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
@csrf
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Nama Lapangan</label>
<input type="text" name="nama" required maxlength="100" placeholder="cth. Lapangan Kenanga" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Lokasi</label>
<input type="text" name="lokasi" maxlength="150" placeholder="cth. Area Selatan (Indoor)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Tipe</label>
<input type="text" name="tipe" maxlength="100" placeholder="cth. Indoor Premium" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Harga / Jam (Rp)</label>
<input type="number" name="harga" required min="0" step="1000" placeholder="350000" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Harga Coret (opsional)</label>
<input type="number" name="harga_coret" min="0" step="1000" placeholder="Kosongkan kalau tidak promo" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Slot Jam (pisahkan koma)</label>
<input type="text" name="slot" maxlength="300" placeholder="cth. 08:00, 10:00, 15:00" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-4">
<label class="block font-label-sm text-label-sm text-outline mb-1">URL Gambar Utama</label>
<input type="url" name="gambar_utama" maxlength="2000" placeholder="https://..." class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan
</button>
</div>
<div class="md:col-span-6">
<label class="block font-label-sm text-label-sm text-outline mb-1">Deskripsi</label>
<input type="text" name="deskripsi" maxlength="1000" placeholder="Deskripsi singkat lapangan untuk halaman pemesanan" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
</form>
</div>

@if ($courts->isEmpty())
<div class="bg-surface-container-lowest rounded-xl p-12 text-center text-on-surface-variant border border-outline-variant/30">
    Belum ada lapangan. Tambahkan lapangan pertama lewat tombol di atas.
</div>
@else
<!-- Courts Grid (Bento-style layout) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-stack-md">
@foreach ($courts as $court)
@php $meta = $court->statusMeta(); @endphp
<div class="card-hover-lift bg-surface-container-lowest rounded-xl p-stack-md ambient-shadow border border-outline-variant/20 relative group transition-all duration-300 {{ ! $court->is_active ? 'opacity-60' : '' }}">
<div class="flex justify-between items-start mb-4">
<div>
<h3 class="font-headline-md text-headline-md text-secondary">{{ $court->nama }}</h3>
<p class="font-body-md text-label-sm text-outline">{{ $court->tipe ?: '—' }}</p>
</div>
<span class="{{ $meta['badge'] }} px-3 py-1 rounded-full font-label-sm text-[9px] uppercase tracking-wider">{{ $meta['label'] }}</span>
</div>

@if ($court->gambar_utama)
<div class="mb-4">
<div class="relative h-28 rounded-lg overflow-hidden mb-3">
<div class="bg-cover bg-center w-full h-full opacity-80" style="background-image: url('{{ $court->gambar_utama }}')"></div>
<div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
@if ($meta['catatan'])
<div class="absolute bottom-2 left-3 text-white">
<p class="font-label-sm text-label-sm flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">info</span> {{ $meta['catatan'] }}</p>
</div>
@endif
</div>
</div>
@else
<div class="mb-4 flex flex-col justify-center h-28 items-center bg-surface-container rounded-lg border border-dashed border-outline-variant/50">
<span class="material-symbols-outlined text-outline text-4xl mb-2">sports_tennis</span>
<p class="font-body-md text-label-sm text-outline text-center px-4">{{ $meta['catatan'] ?: 'Belum ada gambar' }}</p>
</div>
@endif

<div class="flex justify-between items-center text-sm mb-3">
<span class="text-outline font-body-md">Harga / jam:</span>
<span class="font-label-sm text-on-surface">Rp {{ number_format($court->harga, 0, ',', '.') }}</span>
</div>
<div class="flex justify-between items-center text-sm mb-3">
<span class="text-outline font-body-md">Lokasi:</span>
<span class="font-label-sm text-on-surface text-right">{{ $court->lokasi ?: '—' }}</span>
</div>
<div class="flex justify-between items-center text-sm mb-4">
<span class="text-outline font-body-md">Tampil di pemesanan:</span>
<span class="font-label-sm {{ $court->is_active ? 'text-secondary' : 'text-error' }}">{{ $court->is_active ? 'Ya' : 'Tidak' }}</span>
</div>

<!-- Ganti status cepat -->
<form method="POST" action="{{ route('admin.lapangan.status', $court) }}" class="flex items-center gap-2 mb-3">
@csrf
@method('PATCH')
<select name="status" class="flex-1 px-2 py-2 rounded-lg border border-outline-variant bg-surface text-label-sm font-label-sm" @if ($meta['otomatis']) disabled title="Status \"Digunakan\" otomatis dari reservasi aktif, tidak bisa diubah manual" @endif>
<option value="tersedia" @selected($court->status === 'tersedia')>Tersedia</option>
<option value="pemeliharaan" @selected($court->status === 'pemeliharaan')>Pemeliharaan</option>
</select>
<input type="text" name="status_catatan" value="{{ $court->status_catatan }}" placeholder="Catatan (opsional)" maxlength="150" class="flex-1 px-2 py-2 rounded-lg border border-outline-variant bg-surface text-label-sm font-label-sm" @if ($meta['otomatis']) disabled @endif>
<button type="submit" class="p-2 rounded-lg border border-outline-variant/50 hover:border-secondary/50 transition-colors shrink-0" title="Simpan status" @if ($meta['otomatis']) disabled @endif>
<span class="material-symbols-outlined text-[16px]">save</span>
</button>
</form>
@if ($meta['otomatis'])
<p class="font-label-sm text-[10px] text-outline -mt-2 mb-3 flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">autorenew</span> Status "Digunakan" otomatis dari reservasi yang sedang berlangsung, kembali "Tersedia" sendiri begitu selesai.</p>
@endif

<div class="border-t border-outline-variant/20 pt-3 flex justify-between items-center">
<button type="button" onclick="document.getElementById('edit-lapangan-{{ $court->id }}').classList.toggle('hidden')" class="text-primary font-label-sm text-label-sm hover:underline underline-offset-4">Edit Detail</button>
<div class="flex items-center gap-2">
<form method="POST" action="{{ route('admin.lapangan.toggle-aktif', $court) }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="p-1 rounded-lg border border-outline-variant/50 hover:border-tertiary/50 transition-colors" title="{{ $court->is_active ? 'Sembunyikan dari pemesanan' : 'Tampilkan di pemesanan' }}">
        <span class="material-symbols-outlined text-[15px]">{{ $court->is_active ? 'visibility_off' : 'visibility' }}</span>
    </button>
</form>
<form method="POST" action="{{ route('admin.lapangan.destroy', $court) }}" onsubmit="return confirm('Hapus lapangan {{ $court->nama }}?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="p-1 rounded-lg border border-outline-variant/50 hover:border-error/50 hover:text-error transition-colors" title="Hapus lapangan">
        <span class="material-symbols-outlined text-[15px]">delete</span>
    </button>
</form>
</div>
</div>
</div>
@endforeach
</div>

<!-- Form Edit (di luar grid supaya lebar penuh) -->
@foreach ($courts as $court)
<div id="edit-lapangan-{{ $court->id }}" class="hidden bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/30 mt-stack-md">
<p class="font-label-sm text-label-sm text-outline mb-3 uppercase tracking-widest">Edit Lapangan: {{ $court->nama }}</p>
<form method="POST" action="{{ route('admin.lapangan.update', $court) }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
@csrf
@method('PUT')
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Nama Lapangan</label>
<input type="text" name="nama" required maxlength="100" value="{{ $court->nama }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Lokasi</label>
<input type="text" name="lokasi" maxlength="150" value="{{ $court->lokasi }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Tipe</label>
<input type="text" name="tipe" maxlength="100" value="{{ $court->tipe }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Harga / Jam (Rp)</label>
<input type="number" name="harga" required min="0" step="1000" value="{{ $court->harga }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Harga Coret (opsional)</label>
<input type="number" name="harga_coret" min="0" step="1000" value="{{ $court->harga_coret }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<label class="block font-label-sm text-label-sm text-outline mb-1">Slot Jam (pisahkan koma)</label>
<input type="text" name="slot" maxlength="300" value="{{ implode(', ', $court->slot ?? []) }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-4">
<label class="block font-label-sm text-label-sm text-outline mb-1">URL Gambar Utama</label>
<input type="url" name="gambar_utama" maxlength="2000" value="{{ $court->gambar_utama }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div class="md:col-span-2">
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan
</button>
</div>
<div class="md:col-span-6">
<label class="block font-label-sm text-label-sm text-outline mb-1">Deskripsi</label>
<input type="text" name="deskripsi" maxlength="1000" value="{{ $court->deskripsi }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
</form>
</div>
@endforeach
@endif
</main>
</div>
@endsection
