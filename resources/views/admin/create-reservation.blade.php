@extends('layouts.app')

@section('title', 'Tambah Reservasi')

@section('content')
<div class="px-container-margin py-section-gap max-w-3xl mx-auto">
    <h1 class="font-headline-md text-headline-md mb-stack-md">Tambah Reservasi Manual</h1>

    <form action="{{ route('admin.reservasi.store') }}" method="POST" class="space-y-stack-lg bg-surface-container-lowest rounded-lg p-stack-lg">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
            <div>
                <label class="font-label-sm text-label-sm">Pelanggan</label>
                <select name="user_id" required class="w-full rounded-lg border px-3 py-2">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-label-sm text-label-sm">Lapangan</label>
                <select name="court_id" required class="w-full rounded-lg border px-3 py-2">
                    <option value="">-- Pilih Lapangan --</option>
                    @foreach($courts as $c)
                        <option value="{{ $c->id }}">{{ $c->nama }} — {{ $c->lokasi ?? '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
            <div>
                <label class="font-label-sm text-label-sm">Tanggal</label>
                <input type="date" name="tanggal" required class="w-full rounded-lg border px-3 py-2" />
            </div>
            <div>
                <label class="font-label-sm text-label-sm">Waktu (mis. 18:00)</label>
                <input type="text" name="waktu" required placeholder="HH:MM" class="w-full rounded-lg border px-3 py-2" />
            </div>
        </div>

        <div>
            <label class="font-label-sm text-label-sm">Pelatih (opsional)</label>
            <select name="coach_id" class="w-full rounded-lg border px-3 py-2">
                <option value="">-- Tanpa Pelatih --</option>
                @foreach($coaches as $coach)
                    <option value="{{ $coach->id }}">{{ $coach->name }} — Rp{{ number_format($coach->fee) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-secondary text-on-secondary font-label-md text-label-md px-6 py-3 rounded-lg hover:opacity-90 transition-opacity shadow-[0px_4px_20px_rgba(27,48,34,0.15)]">Buat Reservasi</button>
        </div>
    </form>
</div>
@endsection
