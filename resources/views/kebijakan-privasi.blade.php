@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')
<!-- Main Content -->
<main class="px-container-margin py-section-gap max-w-4xl mx-auto w-full">

    <!-- Hero -->
    <header class="reveal text-center mb-section-gap">
        <h1 class="font-display-lg text-display-lg text-secondary mb-stack-md">Kebijakan Privasi</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
            Privasi Anda penting bagi kami. Halaman ini menjelaskan data apa saja yang kami kumpulkan dan bagaimana kami menggunakannya.
        </p>
        <p class="font-label-sm text-label-sm text-outline mt-stack-sm">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>
    </header>

    <!-- Konten -->
    <div class="reveal reveal-delay-1 bg-surface-container-lowest rounded-xl p-container-margin md:p-stack-lg soft-shadow border border-outline-variant/30 space-y-stack-lg">

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">1. Data yang Kami Kumpulkan</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Saat Anda mendaftar akun, melakukan reservasi lapangan, atau mendaftar keanggotaan di Padel Anggun, kami mengumpulkan data berikut:
            </p>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Nama lengkap, alamat email, dan nomor telepon.</li>
                <li>Riwayat reservasi lapangan dan sesi pelatih.</li>
                <li>Informasi paket keanggotaan yang dipilih.</li>
                <li>Data teknis seperti alamat IP dan jenis perangkat, untuk keperluan keamanan sistem.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">2. Bagaimana Kami Menggunakan Data Anda</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Data yang kami kumpulkan digunakan untuk:
            </p>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Memproses dan mengonfirmasi reservasi lapangan serta pendaftaran keanggotaan.</li>
                <li>Mengirimkan notifikasi terkait jadwal, promo, atau perubahan layanan.</li>
                <li>Meningkatkan kualitas layanan dan pengalaman pengguna di situs kami.</li>
                <li>Menjaga keamanan akun dan mencegah penyalahgunaan sistem.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">3. Perlindungan Data</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Kami menyimpan data Anda dengan langkah-langkah keamanan yang wajar, termasuk enkripsi kata sandi dan pembatasan akses hanya kepada staf yang berwenang. Kami tidak menjual atau menyewakan data pribadi Anda kepada pihak ketiga untuk kepentingan pemasaran.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">4. Berbagi Data dengan Pihak Ketiga</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Data Anda hanya dibagikan kepada pihak ketiga apabila diperlukan untuk memproses pembayaran, memenuhi kewajiban hukum, atau atas persetujuan eksplisit dari Anda.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">5. Hak Anda</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Anda berhak untuk mengakses, memperbarui, atau meminta penghapusan data pribadi Anda kapan saja melalui halaman Profil, atau dengan menghubungi kami langsung.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">6. Cookie</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Situs kami menggunakan cookie untuk menjaga sesi login Anda tetap aktif dan meningkatkan pengalaman menjelajah. Anda dapat menonaktifkan cookie melalui pengaturan peramban, namun beberapa fitur situs mungkin tidak berfungsi optimal.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">7. Perubahan Kebijakan</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Kebijakan Privasi ini dapat diperbarui dari waktu ke waktu. Perubahan signifikan akan diinformasikan melalui situs atau email.
            </p>
        </section>

        <section class="space-y-stack-sm pt-stack-sm border-t border-outline-variant/30">
            <h2 class="font-headline-md text-headline-md text-secondary">8. Hubungi Kami</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Jika Anda memiliki pertanyaan mengenai kebijakan privasi ini, silakan hubungi kami melalui halaman
                <a class="text-secondary underline hover:text-tertiary transition-colors" href="{{ route('kontak') }}">Kontak</a>.
            </p>
        </section>

    </div>
</main>
@endsection
