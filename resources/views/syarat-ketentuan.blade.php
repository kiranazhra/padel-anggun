@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')

@section('content')
<!-- Main Content -->
<main class="px-container-margin py-section-gap max-w-4xl mx-auto w-full">

    <!-- Hero -->
    <header class="reveal text-center mb-section-gap">
        <h1 class="font-display-lg text-display-lg text-secondary mb-stack-md">Syarat &amp; Ketentuan</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
            Mohon baca syarat dan ketentuan berikut sebelum menggunakan layanan Padel Anggun.
        </p>
        <p class="font-label-sm text-label-sm text-outline mt-stack-sm">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>
    </header>

    <!-- Konten -->
    <div class="reveal reveal-delay-1 bg-surface-container-lowest rounded-xl p-container-margin md:p-stack-lg soft-shadow border border-outline-variant/30 space-y-stack-lg">

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">1. Penerimaan Ketentuan</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Dengan mengakses dan menggunakan situs serta layanan Padel Anggun (reservasi lapangan, keanggotaan, dan fasilitas lainnya), Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">2. Akun Pengguna</h2>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Anda wajib memberikan informasi yang akurat dan terkini saat mendaftar akun.</li>
                <li>Anda bertanggung jawab penuh atas kerahasiaan kata sandi dan seluruh aktivitas yang terjadi pada akun Anda.</li>
                <li>Padel Anggun berhak menonaktifkan akun yang terindikasi melanggar ketentuan ini atau menyalahgunakan layanan.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">3. Reservasi Lapangan</h2>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Reservasi dinyatakan berlaku setelah menerima konfirmasi dari sistem atau admin.</li>
                <li>Pembatalan atau perubahan jadwal harus dilakukan sesuai kebijakan waktu yang berlaku; pembatalan mendadak dapat dikenakan biaya.</li>
                <li>Keterlambatan kedatangan tidak memperpanjang durasi sesi yang telah dipesan.</li>
                <li>Padel Anggun berhak membatalkan reservasi dalam kondisi force majeure (bencana, cuaca ekstrem, perbaikan darurat fasilitas) dengan pemberitahuan sesegera mungkin.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">4. Keanggotaan</h2>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Setiap paket keanggotaan (Gold, Elite, Premium) memiliki manfaat dan masa berlaku sebagaimana dijelaskan pada halaman Keanggotaan.</li>
                <li>Manfaat keanggotaan bersifat personal dan tidak dapat dipindahtangankan ke pihak lain.</li>
                <li>Perubahan atau upgrade paket dapat dilakukan sewaktu-waktu melalui halaman Keanggotaan.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">5. Pembayaran</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Seluruh biaya reservasi dan keanggotaan harus dilunasi sesuai metode dan tenggat waktu yang ditentukan. Padel Anggun berhak membatalkan reservasi atau keanggotaan yang belum dilunasi sesuai ketentuan.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">6. Tata Tertib Fasilitas</h2>
            <ul class="list-disc list-inside space-y-1 font-body-md text-body-md text-on-surface-variant pl-2">
                <li>Pengguna wajib mengenakan pakaian dan alas kaki olahraga yang sesuai standar lapangan padel.</li>
                <li>Pengguna diharapkan menjaga kebersihan, ketertiban, dan sikap sopan terhadap staf serta pengguna lain.</li>
                <li>Padel Anggun tidak bertanggung jawab atas kehilangan barang pribadi yang tertinggal di area klub.</li>
            </ul>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">7. Batasan Tanggung Jawab</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Olahraga padel memiliki risiko cedera fisik. Dengan menggunakan fasilitas kami, Anda memahami dan menerima risiko tersebut. Padel Anggun tidak bertanggung jawab atas cedera yang timbul akibat kelalaian pribadi pengguna atau di luar kendali wajar pengelola.
            </p>
        </section>

        <section class="space-y-stack-sm">
            <h2 class="font-headline-md text-headline-md text-secondary">8. Perubahan Ketentuan</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Padel Anggun dapat mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan berlaku efektif sejak dipublikasikan di halaman ini.
            </p>
        </section>

        <section class="space-y-stack-sm pt-stack-sm border-t border-outline-variant/30">
            <h2 class="font-headline-md text-headline-md text-secondary">9. Hubungi Kami</h2>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                Untuk pertanyaan lebih lanjut mengenai syarat dan ketentuan ini, silakan hubungi kami melalui halaman
                <a class="text-secondary underline hover:text-tertiary transition-colors" href="{{ route('kontak') }}">Kontak</a>.
            </p>
        </section>

    </div>
</main>
@endsection
