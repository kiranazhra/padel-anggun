@extends('layouts.admin')

@section('title', 'Pengaturan Admin')

@section('content')
<main class="flex-1 md:ml-72 h-full overflow-y-auto bg-background px-container-margin py-stack-lg">
    @include('partials.admin-header', ['titlePrefix' => 'Pengaturan', 'titleAccent' => 'Admin'])

    <div class="max-w-3xl mx-auto">
        <div class="bg-surface-container-lowest rounded-lg p-stack-md ambient-shadow border border-outline-variant/20">
            <h2 class="font-headline-md mb-stack-md">Pengaturan Admin</h2>
            <p class="mb-stack-md">Halaman pengaturan admin masih kosong. Tambahkan opsi konfigurasi di sini.</p>
            <a href="{{ route('admin.dashboard') }}" class="text-outline hover:underline">Kembali ke Dasbor</a>
        </div>
    </div>
</main>
@endsection
