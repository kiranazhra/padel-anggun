@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
@php
    $lapanganUrl = route('lapangan');
    $keanggotaanUrl = route('keanggotaan');
@endphp

<!-- Hero Section -->
<header class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center z-0 w-full h-full" data-alt="A stunning, high-resolution photograph of an upscale, boutique women's padel tennis court. The court features a pristine pastel pink and soft forest green color palette, with elegant glass walls reflecting warm, golden hour sunlight. The surrounding architecture is modern editorial, clean, and luxurious, exuding a serene yet athletic atmosphere. A champagne gold accent subtly catches the light." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCJAFob0uLq3kfc7rAFT1PmYhXFBYRc6RF1R60i7ohjiXmyUUhjEllWrny5eN2wgaiocWFnd2utzdOFgyT468KrSBzqMqQYYybDKpmM0vze8wEMwGGTJGSOU6oA4U4uYWm3rnAkXoYUjEd2Xr0zjdne7L23NQR5DpYbC_NIAJeZax7BBwSaexBt4XeHOGoUZt0khK7ns3vXovBVptKok_wm5jN-CyjpFW6BlQc0pWeCyzxCs3EfaSwINA')"></div>
    <div class="absolute inset-0 bg-surface-tint/40 mix-blend-multiply z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent z-10"></div>
    <div class="relative z-20 text-center px-container-margin max-w-4xl mx-auto mt-section-gap">
        <span class="reveal font-label-sm text-label-sm text-tertiary-fixed tracking-widest uppercase mb-4 block gold-text">Eksklusivitas Butik &amp; Semangat Atletik</span>
        <h1 class="reveal reveal-delay-1 font-display-lg text-display-lg text-on-primary md:text-[44px] leading-tight mb-stack-md font-bold drop-shadow-lg">
            Tingkatkan<br><span class="italic font-light gold-text">Permainan Anda</span>
        </h1>
        <p class="reveal reveal-delay-2 font-body-lg text-body-lg text-surface-bright mb-stack-lg max-w-2xl mx-auto opacity-90">
            Rasakan kemewahan bermain di fasilitas padel kelas dunia yang didesain khusus untuk wanita. Paduan harmoni antara keanggunan, komunitas, dan olahraga profesional dalam satu ruang yang indah.
        </p>

        <div class="reveal reveal-delay-3 flex flex-col sm:flex-row items-center justify-center gap-stack-md">
            <button class="btn-animated w-full sm:w-auto bg-secondary text-on-secondary font-label-sm text-label-sm px-8 py-4 rounded-DEFAULT hover:bg-secondary/90 transition-colors h-[48px] inline-flex items-center justify-center border border-transparent shadow-[0_4px_20px_rgba(27,48,34,0.15)]" onclick="location.href='{{ $lapanganUrl }}'">
                Pesan Lapangan
            </button>

            <button class="btn-animated w-full sm:w-auto bg-transparent text-surface-bright font-label-sm text-label-sm px-8 py-4 rounded-DEFAULT hover:bg-surface-bright/10 transition-colors h-[48px] inline-flex items-center justify-center border border-tertiary-fixed backdrop-blur-sm" onclick="location.href='{{ $keanggotaanUrl }}'">
                Jelajahi Keanggotaan
            </button>
        </div>
    </div>
</header>

<!-- Standar Elit Section -->
<section class="py-section-gap px-container-margin bg-background">
    <div class="max-w-[1200px] mx-auto text-center">
        <h2 class="reveal font-headline-lg text-headline-lg text-secondary mb-stack-md gold-underline inline-block">Standar Elit</h2>
        <div class="gold-divider w-24 mx-auto mb-stack-md"></div>
        <p class="reveal reveal-delay-1 font-body-md text-body-md text-on-surface-variant max-w-3xl mx-auto leading-relaxed">
            Di Padel Anggun, setiap detail dirancang dengan presisi. Dari permukaan lapangan premium yang mendukung performa optimal hingga fasilitas ruang ganti bergaya editorial yang menenangkan. Kami menetapkan standar baru dalam pengalaman olahraga, menggabungkan keramahan premium dengan fasilitas atletik profesional.
        </p>
    </div>
</section>

<!-- Fitur Utama (Bento Grid Style) -->
<section class="py-section-gap px-container-margin bg-surface-container-low">
    <div class="max-w-[1200px] mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <!-- Card 1 -->
            <div class="reveal card-hover-lift md:col-span-2 bg-surface-container-lowest rounded-lg p-stack-lg shadow-[0_4px_20px_rgba(27,48,34,0.06)] flex flex-col justify-between overflow-hidden relative group">
                <div class="z-10 relative">
                    <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full font-label-sm text-[9px] mb-stack-sm inline-block">Fasilitas</span>
                    <h3 class="font-headline-md text-headline-md text-secondary mb-stack-sm">Lapangan Premium</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                        Permukaan berstandar turnamen internasional dengan pencahayaan anti-silau, memastikan setiap pukulan dilakukan dengan presisi sempurna.
                    </p>
                </div>

                <div class="mt-stack-lg z-10 relative">
                    <a class="inline-flex items-center font-label-sm text-label-sm text-secondary hover:text-tertiary transition-colors" href="{{ route('lapangan') }}">
                        Lihat Detail <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="absolute -bottom-10 -right-10 opacity-10 group-hover:opacity-20 transition-opacity float-slow">
                    <span class="material-symbols-outlined text-[140px] text-secondary">sports_tennis</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="reveal reveal-delay-1 card-hover-lift bg-primary-fixed/30 rounded-lg p-stack-lg shadow-[0_4px_20px_rgba(27,48,34,0.06)] flex flex-col justify-between">
                <div>
                    <span class="bg-surface-container-lowest text-secondary px-3 py-1 rounded-full font-label-sm text-[9px] mb-stack-sm inline-block shadow-sm">Pelatihan</span>
                    <h3 class="font-headline-md text-headline-md text-primary mb-stack-sm">Pelatih Ahli</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Tingkatkan teknik Anda bersama jajaran pelatih bersertifikat kami yang berdedikasi untuk kemajuan Anda.
                    </p>
                </div>

                <div class="mt-stack-lg">
                    <a class="inline-flex items-center font-label-sm text-label-sm text-primary hover:text-tertiary transition-colors" href="{{ route('lapangan') }}">
                        Temui Pelatih <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="reveal reveal-delay-2 card-hover-lift md:col-span-3 bg-surface-container-lowest rounded-lg p-stack-lg shadow-[0_4px_20px_rgba(27,48,34,0.06)] border border-outline-variant/30 flex flex-col md:flex-row items-center gap-stack-lg overflow-hidden">
                <div class="flex-1">
                    <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full font-label-sm text-[9px] mb-stack-sm inline-block">Kehidupan Sosial</span>
                    <h3 class="font-headline-md text-headline-md text-secondary mb-stack-sm">Komunitas Dinamis</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-stack-md">
                        Bergabunglah dengan jaringan wanita inspiratif. Dari turnamen akhir pekan hingga sesi networking santai di kafe butik kami, jadilah bagian dari sesuatu yang lebih besar dari sekadar olahraga.
                    </p>

                    <button class="btn-animated bg-transparent text-secondary font-label-sm text-label-sm px-6 py-2 rounded-DEFAULT hover:bg-secondary/5 transition-colors border border-tertiary h-[48px] inline-flex items-center justify-center" onclick="location.href='{{ $keanggotaanUrl }}'">
                        Gabung Komunitas
                    </button>
                </div>

                <div class="flex-1 w-full relative h-[220px] rounded-DEFAULT overflow-hidden">
                    <div class="absolute inset-0 bg-cover bg-center w-full h-full" data-alt="A candid, vibrant photo of a diverse group of stylish women laughing and socializing at a chic, boutique padel club cafe. They are dressed in elegant, pastel-toned athletic wear. The setting is modern and bright, with subtle forest green accents and warm natural lighting, embodying a dynamic and supportive community spirit." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCdk47erzPVA7rtwoGppF8PIL9Jb4Z0pfzsutfDasQrbwhiQ5cIyUVbf3kKQpH4oxlsk2PLbDVusliuT-wO-3hq_snaBV79mvKQnbfQMBVbZEkiccPrfH5WR23orMcwNI3oCZMrRiwgpbkLZe0GFz2bmEtCkUaWXw1BklkqKCji_PQLv7Sx9mRxC51BX_DK8ZkchsNyON_RPYUABfcR8vR6CItUbj3zR63aY8V6Pr9y3JYUXnPZ4lsIsQ')"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@endsection
