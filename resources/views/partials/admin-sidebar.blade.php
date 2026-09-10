<!-- SideNavBar (Desktop) -->
<nav id="pa-sidebar" class="pa-sidebar bg-surface dark:bg-inverse-surface h-screen w-72 fixed left-0 top-0 border-r border-outline-variant shadow-sm hidden md:flex flex-col py-base z-50 transition-all duration-300">
    <button id="pa-sidebar-toggle" type="button" aria-label="Perkecil atau perbesar sidebar" class="absolute -right-3 top-9 w-7 h-7 rounded-full bg-surface border border-outline-variant shadow-md items-center justify-center text-on-surface-variant hover:text-secondary hover:border-secondary transition-colors z-10 hidden md:flex">
        <span class="material-symbols-outlined text-[12px]" id="pa-sidebar-toggle-icon">chevron_left</span>
    </button>
    <div class="px-gutter mb-stack-lg mt-stack-md text-center pa-sidebar-brand">
        <!-- Full logo for expanded sidebar (slightly larger for admin) -->
        <img src="{{ asset('img/logo-padel-anggun2.png') }}" alt="Padel Anggun" class="mx-auto h-18 pa-sidebar-label" />
        <!-- Small icon for collapsed sidebar (keep original file) -->
        <img src="{{ asset('img/logo-padel-anggun.png') }}" alt="Padel Anggun" class="mx-auto h-12 pa-sidebar-icon-only" />
        <p class="sr-only">Klub Padel Anggun</p>
        <p class="font-label-sm text-label-sm text-on-surface-variant mt-1 pa-sidebar-label">Management Portal</p>
    </div>

    <div class="flex-1 overflow-y-auto mt-4 px-3 space-y-1">
        <div class="mb-2">
            <a href="{{ route('admin.reservasi.create') }}" class="w-full bg-secondary text-on-secondary font-label-md text-label-md py-3 px-4 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2 h-12 shadow-[0px_4px_20px_rgba(27,48,34,0.15)]" title="Tambah Reservasi">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
                <span class="pa-sidebar-label">Tambah Reservasi</span>
            </a>
        </div>

        @php
            $adminLinks = [
                ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'iconFill' => true, 'label' => 'Ringkasan'],
                ['route' => 'admin.lapangan', 'icon' => 'sports_tennis', 'iconFill' => false, 'label' => 'Kelola Lapangan'],
                ['route' => 'admin.anggota', 'icon' => 'group', 'iconFill' => false, 'label' => 'Manajemen Anggota'],
                ['route' => 'admin.jadwal-pelatih', 'icon' => 'calendar_today', 'iconFill' => false, 'label' => 'Jadwal Pelatih'],
                ['route' => 'admin.promo', 'icon' => 'sell', 'iconFill' => false, 'label' => 'Pengaturan Promo'],
                ['route' => 'admin.laporan-keuangan', 'icon' => 'payments', 'iconFill' => false, 'label' => 'Laporan Keuangan'],
            ];
        @endphp

        @foreach ($adminLinks as $link)
            <a class="pa-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'text-secondary font-bold border-r-4 border-tertiary bg-secondary-container/30 scale-[0.98] transition-transform' : 'text-on-surface-variant opacity-80 hover:bg-secondary-container' }}"
               href="{{ route($link['route']) }}" title="{{ $link['label'] }}">
                <span class="material-symbols-outlined" @if($link['iconFill']) style="font-variation-settings: 'FILL' 1;" @endif>{{ $link['icon'] }}</span>
                <span class="font-label-sm text-label-sm pa-sidebar-label">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </div>

    <div class="mt-auto px-3 border-t border-outline-variant/30 pt-4 space-y-1">
        <a class="pa-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant opacity-80 hover:bg-secondary-container transition-colors duration-200" href="https://wa.me/628134256613?text={{ urlencode('Halo tim support Padel Anggun, saya butuh bantuan terkait panel admin.') }}" target="_blank" rel="noopener noreferrer" title="Bantuan">
            <span class="material-symbols-outlined">help</span>
            <span class="font-label-sm text-label-sm pa-sidebar-label">Bantuan</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full pa-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant opacity-80 hover:bg-secondary-container transition-colors duration-200 text-left" title="Keluar">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-label-sm text-label-sm pa-sidebar-label">Keluar</span>
            </button>
        </form>
    </div>
</nav>
