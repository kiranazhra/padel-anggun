@extends('layouts.admin')

@section('title', 'Jadwal Pelatih')

@section('content')
<!-- Main Content Canvas -->
<main class="flex-1 w-full md:ml-72 flex flex-col min-h-screen relative">
<!-- TopAppBar -->
@include('partials.admin-header', ['titlePrefix' => 'Jadwal', 'titleAccent' => 'Pelatih'])
<div class="p-container-margin md:p-stack-lg max-w-[1200px] mx-auto w-full flex-1">

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

<!-- Subtitle + Date Navigator -->
<div class="flex flex-col md:flex-row justify-between items-center mb-stack-lg gap-4">
<p class="font-body-md text-body-md text-outline flex-1">Kelola data pelatih, sesi privat, akademi, dan waktu istirahat.</p>
<div class="flex items-center gap-4 bg-surface-container-low px-4 py-2 rounded-lg border border-outline-variant/30">
<a class="p-1 hover:bg-surface-variant/50 rounded-full transition-colors" href="{{ route('admin.jadwal-pelatih', ['date' => $date->copy()->subDay()->toDateString()]) }}">
<span class="material-symbols-outlined text-outline">chevron_left</span>
</a>
<span class="font-body-md text-body-lg font-semibold text-on-background">{{ $date->translatedFormat('l, d M Y') }}</span>
<a class="p-1 hover:bg-surface-variant/50 rounded-full transition-colors" href="{{ route('admin.jadwal-pelatih', ['date' => $date->copy()->addDay()->toDateString()]) }}">
<span class="material-symbols-outlined text-outline">chevron_right</span>
</a>
</div>
</div>

<!-- Kelola Pelatih (CRUD data pelatih) -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 mb-stack-lg overflow-hidden">
<div class="p-4 flex justify-between items-center border-b border-outline-variant/30 bg-surface-container-low">
<h3 class="font-headline-md text-body-lg text-on-background">Kelola Pelatih</h3>
<button type="button" onclick="document.getElementById('tambah-pelatih-form').classList.toggle('hidden')" class="bg-secondary text-on-secondary px-4 py-1.5 rounded-lg text-label-sm font-semibold hover:bg-secondary/90 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-[15px]">person_add</span>
    Tambah Pelatih
</button>
</div>

<!-- Form Tambah Pelatih -->
<div id="tambah-pelatih-form" class="hidden p-4 border-b border-outline-variant/30 bg-surface-container-low">
<form method="POST" action="{{ route('admin.pelatih.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
@csrf
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Nama Pelatih</label>
<input type="text" name="name" required maxlength="100" placeholder="cth. Coach Dinda" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Spesialisasi</label>
<input type="text" name="specialty" maxlength="150" placeholder="cth. Sesi Privat" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Biaya Sesi (Rp)</label>
<input type="number" name="fee" required min="0" step="1000" value="150000" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan Pelatih
</button>
</div>
</form>
</div>

<!-- Daftar Pelatih -->
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="border-b border-outline-variant/30 text-on-surface-variant font-label-sm text-label-sm uppercase bg-surface-container-low">
<th class="px-4 py-3 font-semibold">Nama</th>
<th class="px-4 py-3 font-semibold">Spesialisasi</th>
<th class="px-4 py-3 font-semibold">Biaya Sesi</th>
<th class="px-4 py-3 font-semibold">Status</th>
<th class="px-4 py-3 font-semibold text-right">Aksi</th>
</tr>
</thead>
<tbody class="font-body-md text-body-md text-on-background">
@forelse ($allCoaches as $c)
<tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors align-top">
<td class="px-4 py-3 font-semibold">{{ $c->name }}</td>
<td class="px-4 py-3 text-on-surface-variant">{{ $c->specialty ?? '-' }}</td>
<td class="px-4 py-3">Rp {{ number_format($c->fee, 0, ',', '.') }}</td>
<td class="px-4 py-3">
@if ($c->is_active)
<span class="bg-secondary-fixed/50 text-on-secondary-fixed px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>
@else
<span class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full text-xs font-semibold">Nonaktif</span>
@endif
</td>
<td class="px-4 py-3">
<div class="flex justify-end gap-2">
<button type="button" onclick="document.getElementById('edit-pelatih-{{ $c->id }}').classList.toggle('hidden')" class="p-1.5 rounded-lg border border-outline-variant/50 hover:border-tertiary/50 transition-colors" title="Edit pelatih">
<span class="material-symbols-outlined text-[16px]">edit</span>
</button>
<form method="POST" action="{{ route('admin.pelatih.toggle-aktif', $c) }}">
    @csrf
    @method('PATCH')
    <button type="submit" class="p-1.5 rounded-lg border border-outline-variant/50 hover:border-tertiary/50 transition-colors" title="{{ $c->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
        <span class="material-symbols-outlined text-[16px]">{{ $c->is_active ? 'visibility_off' : 'visibility' }}</span>
    </button>
</form>
<form method="POST" action="{{ route('admin.pelatih.destroy', $c) }}" onsubmit="return confirm('Hapus pelatih {{ $c->name }} beserta seluruh jadwalnya?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="p-1.5 rounded-lg border border-outline-variant/50 hover:border-error/50 hover:text-error transition-colors" title="Hapus pelatih">
        <span class="material-symbols-outlined text-[16px]">delete</span>
    </button>
</form>
</div>
</td>
</tr>
<tr id="edit-pelatih-{{ $c->id }}" class="hidden bg-surface-container-low">
<td colspan="5" class="px-4 py-4">
<form method="POST" action="{{ route('admin.pelatih.update', $c) }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
@csrf
@method('PUT')
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Nama Pelatih</label>
<input type="text" name="name" required maxlength="100" value="{{ $c->name }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Spesialisasi</label>
<input type="text" name="specialty" maxlength="150" value="{{ $c->specialty }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<label class="block font-label-sm text-label-sm text-outline mb-1">Biaya Sesi (Rp)</label>
<input type="number" name="fee" required min="0" step="1000" value="{{ $c->fee }}" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>
<div>
<button type="submit" class="w-full bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan Perubahan
</button>
</div>
</form>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="px-4 py-8 text-center text-on-surface-variant">Belum ada data pelatih. Tambahkan pelatih pertama di atas.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>

<!-- Schedule Canvas -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 overflow-x-auto relative">
<!-- Legend -->
<div class="p-4 flex flex-wrap gap-4 border-b border-outline-variant/30 bg-surface-container-low justify-between items-center">
<div class="flex flex-wrap gap-6 items-center">
<span class="font-body-md text-label-sm text-on-surface-variant">
{{ $sessions->count() }} sesi terjadwal hari ini
</span>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded-full" style="background-color: #f4d7d3; border: 1px solid #a6433c;"></div>
<span class="font-body-md text-label-sm text-on-background">Sesi Privat</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded-full" style="background-color: #cde6d1; border: 1px solid #4d6453;"></div>
<span class="font-body-md text-label-sm text-on-background">Kelas Akademi</span>
</div>
<div class="flex items-center gap-2">
<div class="w-4 h-4 rounded-full" style="background-color: #e5e2de; border: 1px solid #8d8380;"></div>
<span class="font-body-md text-label-sm text-on-background">Istirahat</span>
</div>
</div>
<div class="flex gap-2">
<form method="POST" action="{{ route('admin.jadwal-pelatih.sinkronkan') }}">
    @csrf
    <button type="submit" class="border border-outline-variant text-on-surface-variant px-4 py-1.5 rounded-lg text-label-sm font-semibold hover:bg-surface-container-high transition-colors flex items-center gap-2" title="Buat ulang sesi untuk reservasi yang sudah punya pelatih tapi belum muncul di jadwal">
        <span class="material-symbols-outlined text-[15px]">sync</span>
        Sinkronkan dari Reservasi
    </button>
</form>
<button type="button" onclick="resetSesiForm(); document.getElementById('tambah-sesi-form').classList.toggle('hidden')" class="bg-secondary text-on-secondary px-4 py-1.5 rounded-lg text-label-sm font-semibold hover:bg-secondary/90 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-[15px]">add_task</span>
    Tambah Sesi
</button>
</div>
</div>

<!-- Form Tambah / Edit Sesi -->
<div id="tambah-sesi-form" class="hidden p-4 border-b border-outline-variant/30 bg-surface-container-low">
<p id="sesi-form-title" class="font-label-sm text-label-sm text-outline mb-2 uppercase tracking-widest">Tambah Sesi Baru</p>
<form method="POST" id="sesi-form" action="{{ route('admin.jadwal-pelatih.store') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
@csrf
<input type="hidden" name="_method" id="sesi-form-method" value="POST">
<input type="hidden" name="session_date" value="{{ $date->toDateString() }}">

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Pelatih</label>
<select name="coach_id" id="sesi-coach_id" required class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
@foreach ($coaches as $coach)
<option value="{{ $coach->id }}">{{ $coach->name }}</option>
@endforeach
</select>
</div>

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Tipe</label>
<select name="type" id="sesi-type" required class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
<option value="privat">Sesi Privat</option>
<option value="akademi">Kelas Akademi</option>
<option value="istirahat">Istirahat</option>
</select>
</div>

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Judul</label>
<input type="text" name="title" id="sesi-title" required maxlength="100" placeholder="cth. Privat: Bpk. Haryo" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Jam Mulai</label>
<select name="start_time" id="sesi-start_time" required class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
@foreach ($hours as $h)
<option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
@endforeach
</select>
</div>

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Durasi</label>
<select name="duration" id="sesi-duration" required class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
<option value="1">1 jam</option>
<option value="2">2 jam</option>
<option value="3">3 jam</option>
</select>
</div>

<div class="md:col-span-1">
<label class="block font-label-sm text-label-sm text-outline mb-1">Lapangan / Catatan</label>
<input type="text" name="location" id="sesi-location" maxlength="100" placeholder="cth. Lapangan 1" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface text-body-md">
</div>

<div class="md:col-span-6 flex justify-end gap-2">
<button type="button" id="sesi-form-cancel" onclick="resetSesiForm(); document.getElementById('tambah-sesi-form').classList.add('hidden');" class="hidden border border-outline-variant text-on-surface-variant px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-surface-container-high transition-colors">
    Batal
</button>
<button type="submit" id="sesi-form-submit" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg font-label-sm text-label-sm hover:bg-secondary/90 transition-colors">
    Simpan Sesi
</button>
</div>
</form>
</div>

<script>
function resetSesiForm() {
    var form = document.getElementById('sesi-form');
    form.action = "{{ route('admin.jadwal-pelatih.store') }}";
    document.getElementById('sesi-form-method').value = 'POST';
    document.getElementById('sesi-form-title').textContent = 'Tambah Sesi Baru';
    document.getElementById('sesi-form-submit').textContent = 'Simpan Sesi';
    document.getElementById('sesi-form-cancel').classList.add('hidden');
    form.reset();
}

function editSesi(session) {
    var form = document.getElementById('sesi-form');
    form.action = "{{ url('/admin/jadwal-pelatih') }}/" + session.id;
    document.getElementById('sesi-form-method').value = 'PUT';
    document.getElementById('sesi-form-title').textContent = 'Edit Sesi';
    document.getElementById('sesi-form-submit').textContent = 'Simpan Perubahan';
    document.getElementById('sesi-form-cancel').classList.remove('hidden');

    document.getElementById('sesi-coach_id').value = session.coach_id;
    document.getElementById('sesi-type').value = session.type;
    document.getElementById('sesi-title').value = session.title;
    document.getElementById('sesi-start_time').value = session.start_time;
    document.getElementById('sesi-duration').value = session.duration;
    document.getElementById('sesi-location').value = session.location || '';

    document.getElementById('tambah-sesi-form').classList.remove('hidden');
}
</script>

@if ($coaches->isEmpty())
<div class="p-12 text-center text-on-surface-variant">
    Belum ada pelatih aktif. Tambahkan data pelatih terlebih dahulu.
</div>
@else
<!-- Grid -->
<div class="min-w-[800px] p-4">
<div class="schedule-grid" style="grid-template-columns: 80px repeat({{ $coaches->count() }}, 1fr); grid-template-rows: auto repeat({{ count($hours) }}, 60px);">
<!-- Headers -->
<div class="schedule-header border-b border-r border-outline-variant/50">
<span class="font-body-md text-label-sm text-outline">Waktu</span>
</div>
@foreach ($coaches as $coach)
<div class="schedule-header border-b border-outline-variant/50">
<div class="flex flex-col items-center gap-2">
<div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-headline-md text-body-lg border-2 border-secondary-container">
    {{ strtoupper(substr(str_replace('Coach ', '', $coach->name), 0, 2)) }}
</div>
<span class="font-headline-md text-body-md text-on-background">{{ $coach->name }}</span>
</div>
</div>
@endforeach

@foreach ($hours as $hour)
<div class="time-label font-body-md text-label-sm text-outline pt-2 border-b border-outline-variant/20">{{ sprintf('%02d:00', $hour) }}</div>
@foreach ($coaches as $coach)
@php $session = $grid[$hour][$coach->id] ?? null; @endphp
@if (isset($covered[$coach->id][$hour]))
    {{-- ditutupi visual sesi yang mulai di jam sebelumnya, tetap render sel kosong --}}
    <div class="schedule-cell border-b border-r border-outline-variant/20"></div>
@else
<div class="schedule-cell border-b border-r border-outline-variant/20 relative">
@if ($session)
@php
    $span = min($session->durationHours(), 3);
    // Kolom "type" di database Indonesia (privat/akademi/istirahat). Warna
    // ditulis langsung sebagai style inline (bukan cuma class CSS) supaya
    // kotak sesi PASTI kelihatan berwarna, tidak bergantung pada file CSS
    // eksternal ke-refresh/cache atau tidaknya di browser.
    $warna = match ($session->type) {
        'akademi' => ['bg' => '#cde6d1', 'border' => '#4d6453', 'text' => '#204a2b'],
        'istirahat' => ['bg' => '#e5e2de', 'border' => '#8d8380', 'text' => '#3a332f'],
        default => ['bg' => '#f4d7d3', 'border' => '#a6433c', 'text' => '#6b241f'],
    };
    // Tinggi kotak juga dihitung & ditulis langsung sebagai style inline
    // (bukan cuma class row-span-N) supaya sesi 2-3 jam PASTI kelihatan
    // memanjang sesuai durasinya, tidak bergantung file CSS eksternal.
    $tinggiPx = ($span * 61) - 2; // 1 baris = 60px + 1px gap grid
@endphp
<div class="slot-event top-0 mt-1" style="background-color: {{ $warna['bg'] }}; border: 1px solid {{ $warna['border'] }}; color: {{ $warna['text'] }}; height: {{ $tinggiPx }}px; z-index: 10;">
<div class="flex justify-between items-start gap-1">
<span class="font-body-md text-label-sm font-semibold block leading-tight">{{ $session->title }}</span>
<div class="flex items-center gap-0.5 shrink-0 -mt-0.5 -mr-0.5">
<button type="button" onclick='editSesi({{ Illuminate\Support\Js::from([
        "id" => $session->id,
        "coach_id" => $session->coach_id,
        "type" => $session->type,
        "title" => $session->title,
        "start_time" => $session->start_time,
        "duration" => $session->durationHours(),
        "location" => $session->location,
    ]) }})' class="opacity-60 hover:opacity-100 transition-opacity p-0.5 rounded hover:bg-black/5" title="Edit sesi">
    <span class="material-symbols-outlined text-[14px] block">edit</span>
</button>
<form method="POST" action="{{ route('admin.jadwal-pelatih.destroy', $session) }}" onsubmit="return confirm('Hapus sesi ini?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="opacity-60 hover:opacity-100 transition-opacity p-0.5 rounded hover:bg-black/5" title="Hapus sesi">
        <span class="material-symbols-outlined text-[14px] block">close</span>
    </button>
</form>
</div>
</div>
<span class="font-body-md text-[9px] opacity-80 flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[12px]">schedule</span> {{ $session->start_time }} - {{ $session->end_time }}</span>
@if ($session->location)
<span class="font-body-md text-[9px] opacity-80 flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[12px]">sports_tennis</span> {{ $session->location }}</span>
@endif
@if ($session->notes)
<span class="font-body-md text-[9px] opacity-80 flex items-center gap-1 mt-0.5"><span class="material-symbols-outlined text-[12px]">group</span> {{ $session->notes }}</span>
@endif
</div>
@endif
</div>
@endif
@endforeach
@endforeach
</div>
</div>
@endif
</div>
</div>
</main>
@endsection
