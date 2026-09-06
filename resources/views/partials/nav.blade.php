<!-- TopNavBar -->
<nav class="bg-surface-bright dark:bg-surface-dim w-full top-0 sticky border-b border-outline-variant/30 dark:border-outline/20 shadow-sm z-50">
    <div class="flex justify-between items-center px-container-margin py-stack-md max-w-[1200px] mx-auto">
        <a class="font-headline-md text-headline-md font-semibold text-secondary dark:text-secondary-fixed flex items-center gap-3" href="{{ route('home') }}">
            <img src="{{ asset('img/logo-padel-anggun2.png') }}" alt="Padel Anggun" class="h-14" />
            <span class="sr-only">Padel Anggun</span>
        </a>
        <div class="hidden md:flex space-x-stack-lg">
            <a class="nav-underline {{ request()->routeIs('home') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-all duration-300 px-2 rounded' }} transition-transform" href="{{ route('home') }}">
                <span class="font-label-md text-label-md">Beranda</span>
            </a>
            <a class="nav-underline {{ request()->routeIs('lapangan') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-all duration-300 px-2 rounded' }}" href="{{ route('lapangan') }}">
                <span class="font-label-md text-label-md">Lapangan</span>
            </a>
            <a class="nav-underline {{ request()->routeIs('keanggotaan') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-all duration-300 px-2 rounded' }}" href="{{ route('keanggotaan') }}">
                <span class="font-label-md text-label-md">Keanggotaan</span>
            </a>
            <a class="nav-underline {{ request()->routeIs('kontak') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-all duration-300 px-2 rounded' }}" href="{{ route('kontak') }}">
                <span class="font-label-md text-label-md">Kontak</span>
            </a>
        </div>
        <div class="hidden md:flex items-center gap-stack-md">
            @auth
                <a class="nav-underline {{ request()->routeIs('dashboard') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors' }} font-label-md text-label-md px-1" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                @if (auth()->user()->isAdmin())
                    <a class="nav-underline {{ request()->routeIs('admin.*') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors' }} font-label-md text-label-md px-1" href="{{ route('admin.dashboard') }}">
                        Admin
                    </a>
                @endif
                <!-- Avatar profil (gaya sama seperti panel admin), bisa diklik untuk buka menu edit profil / keluar -->
                <div class="relative">
                    <button type="button" onclick="document.getElementById('nav-profile-menu').classList.toggle('hidden')" class="w-10 h-10 rounded-full border-2 border-outline-variant/30 overflow-hidden cursor-pointer hover:border-tertiary transition-colors bg-secondary-container flex items-center justify-center shrink-0" title="{{ auth()->user()->name }}">
                        <span class="font-headline-md text-body-md text-on-secondary-container">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </button>
                    <div id="nav-profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-surface-bright dark:bg-surface-dim rounded-lg shadow-xl border border-outline-variant/30 overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-outline-variant/20">
                            <p class="font-label-sm text-label-sm font-semibold text-on-surface truncate">{{ auth()->user()->name }}</p>
                            <p class="font-label-sm text-[11px] text-on-surface-variant truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 font-label-sm text-label-sm text-on-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-container-highest hover:text-secondary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span> Edit Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 font-label-sm text-label-sm text-error hover:bg-error-container/40 transition-colors text-left">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a class="nav-underline {{ request()->routeIs('register') ? 'is-active text-secondary dark:text-secondary-fixed font-semibold' : 'text-on-surface-variant dark:text-surface-variant hover:text-secondary transition-colors' }} font-label-md text-label-md px-1" href="{{ route('register') }}">
                    Daftar
                </a>
                <a class="btn-animated gold-focus bg-secondary text-on-secondary font-label-md text-label-md px-6 h-[48px] rounded-DEFAULT hover:bg-secondary/90 transition-colors inline-flex items-center justify-center border border-transparent" href="{{ route('login') }}">
                    Masuk
                </a>
            @endauth
        </div>
        <button aria-label="Menu" class="md:hidden text-secondary">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </div>
</nav>
