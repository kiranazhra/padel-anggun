@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<main class="flex-1 md:ml-72 h-full overflow-y-auto bg-background px-container-margin py-stack-lg">
    @include('partials.admin-header', ['titlePrefix' => 'Profil', 'titleAccent' => 'Admin'])

    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-surface-container-lowest rounded-lg p-6 border border-outline-variant/20">
            <h1 class="font-headline-md mb-2">Profil Saya</h1>
            <p class="text-on-surface-variant mb-4">Perbarui informasi akun Anda.</p>

            @if(session('status'))
                <div class="mb-4 p-3 bg-success-container text-on-success-container rounded">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="font-label-sm text-xs text-outline">Nama</label>
                        <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded border border-outline-variant/20 p-2" />
                        @error('name') <div class="text-error text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="font-label-sm text-xs text-outline">Email</label>
                        <input name="email" value="{{ old('email', $user->email) }}" class="mt-1 w-full rounded border border-outline-variant/20 p-2" />
                        @error('email') <div class="text-error text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="font-label-sm text-xs text-outline">Password (biarkan kosong untuk tidak mengubah)</label>
                        <input name="password" type="password" class="mt-1 w-full rounded border border-outline-variant/20 p-2" />
                        @error('password') <div class="text-error text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="font-label-sm text-xs text-outline">Konfirmasi Password</label>
                        <input name="password_confirmation" type="password" class="mt-1 w-full rounded border border-outline-variant/20 p-2" />
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-tertiary-fixed text-on-tertiary-fixed px-4 py-2 rounded">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
