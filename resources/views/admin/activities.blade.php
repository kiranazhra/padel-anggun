@extends('layouts.admin')

@section('title', 'Semua Aktivitas')

@section('content')
<main class="flex-1 md:ml-72 h-full overflow-y-auto bg-background px-container-margin py-stack-lg">
    @include('partials.admin-header', ['titlePrefix' => 'Aktivitas', 'titleAccent' => 'Semua'])

    <div class="max-w-4xl mx-auto">
        <div class="bg-surface-container-lowest rounded-lg p-stack-md ambient-shadow border border-outline-variant/20">
            <h2 class="font-headline-md mb-stack-md">Feed Aktivitas</h2>

            <form method="GET" class="flex gap-3 items-end mb-stack-md flex-wrap">
                <div>
                    <label class="font-label-sm text-label-sm">Tipe</label>
                    <select name="type" class="rounded-lg border px-3 py-2">
                        <option value="all" {{ (request('type', 'all') == 'all') ? 'selected' : '' }}>Semua</option>
                        <option value="registration" {{ (request('type') == 'registration') ? 'selected' : '' }}>Pendaftaran</option>
                        <option value="booking" {{ (request('type') == 'booking') ? 'selected' : '' }}>Booking</option>
                        <option value="confirmed" {{ (request('type') == 'confirmed') ? 'selected' : '' }}>Konfirmasi</option>
                        <option value="cancelled" {{ (request('type') == 'cancelled') ? 'selected' : '' }}>Pembatalan</option>
                    </select>
                </div>

                <div>
                    <label class="font-label-sm text-label-sm">Dari</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-lg border px-3 py-2" />
                </div>

                <div>
                    <label class="font-label-sm text-label-sm">Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-lg border px-3 py-2" />
                </div>

                <div class="flex-1 min-w-[180px]">
                    <label class="font-label-sm text-label-sm">Cari</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari teks..." class="w-full rounded-lg border px-3 py-2" />
                </div>

                <div>
                    <button type="submit" class="bg-secondary text-on-secondary px-4 py-2 rounded-lg">Filter</button>
                    <a href="{{ route('admin.aktivitas') }}" class="ml-2 text-outline hover:underline">Reset</a>
                </div>
            </form>

            @if($aktivitas->isEmpty())
                <p class="font-body-md text-sm text-outline">Belum ada aktivitas.</p>
            @else
                <div class="flex flex-col gap-4">
                    @foreach($aktivitas as $item)
                        <div class="flex gap-stack-sm pb-4 border-b border-outline-variant/20 last:border-0 last:pb-0">
                            <div class="w-10 h-10 rounded-full {{ $item['iconBg'] }} flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined {{ $item['iconColor'] }} text-base">{{ $item['icon'] }}</span>
                            </div>
                            <div>
                                <p class="font-body-md text-sm text-on-background">{!! $item['text'] !!}</p>
                                <p class="font-label-sm text-xs text-outline mt-1">{{ $item['time']->translatedFormat('d F Y H:i') }} — {{ $item['time']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(isset($logs))
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            @endif

            <div class="mt-stack-md flex justify-end">
                <a href="{{ route('admin.dashboard') }}" class="text-outline hover:underline">Kembali ke Dasbor</a>
            </div>
        </div>
    </div>
</main>
@endsection
