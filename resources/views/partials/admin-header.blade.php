{{--
    Header admin yang dipakai di semua halaman panel admin, supaya tampilannya
    konsisten seperti di Ringkasan Utama: judul halaman, tanggal hari ini
    (otomatis, bukan teks statis), tombol notifikasi & pengaturan, dan avatar
    profil admin yang sedang login.

    Parameter:
    - $titlePrefix (string) — bagian judul warna biasa, cth. "Jadwal"
    - $titleAccent (string) — bagian judul warna emas, cth. "Pelatih"
    - $headerClass (string, opsional) — class tambahan pada <header>, dipakai
      halaman Ringkasan Utama yang butuh -mx-container-margin mb-stack-lg
--}}
@php
    $headerClass = $headerClass ?? '';
@endphp
<header id="adminHeader" class="bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 docked full-width top-0 sticky z-40 flex justify-between items-center px-gutter h-16 shadow-none {{ $headerClass }}" data-settings-mode="{{ config('admin.settings_button', 'link') }}">
<h2 class="reveal font-headline-md text-headline-md text-secondary">{{ $titlePrefix }} <span class="gold-text">{{ $titleAccent }}</span></h2>
<div class="flex items-center gap-4 md:gap-6">
<div class="hidden md:flex items-center gap-2 text-on-surface-variant font-label-sm text-label-sm">
<span class="material-symbols-outlined text-[15px]">calendar_today</span>
<span>{{ now()->translatedFormat('l, d M Y') }}</span>
</div>
<a id="headerNotifBtn" href="{{ route('admin.aktivitas') }}" class="relative text-on-surface-variant hover:text-tertiary transition-colors p-2 rounded-full" title="Notifikasi">
    <span class="material-symbols-outlined">notifications</span>
    @if(isset($unreadNotifications) && $unreadNotifications > 0)
        <span id="headerNotifBadge" class="absolute -top-1 -right-1 w-2 h-2 bg-pink-500 rounded-full ring-1 ring-white"></span>
    @endif
</a>
@php $settingsMode = config('admin.settings_button', 'link'); @endphp

@if($settingsMode === 'link')
    <a id="headerSettingsBtn" href="{{ route('admin.settings') }}" class="text-on-surface-variant hover:text-tertiary transition-colors p-2 rounded-full" title="Pengaturan">
        <span class="material-symbols-outlined">settings</span>
    </a>
@elseif($settingsMode === 'modal')
    <button id="headerSettingsBtn" type="button" class="text-on-surface-variant hover:text-tertiary transition-colors p-2 rounded-full" title="Pengaturan">
        <span class="material-symbols-outlined">settings</span>
    </button>
    <!-- Settings Modal -->
    <div id="settingsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="bg-surface-container-lowest rounded-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-headline-sm">Pengaturan</h3>
                <button id="settingsClose" class="p-1">&times;</button>
            </div>
            <div>
                <a href="{{ route('admin.settings') }}" class="block py-2 text-on-background hover:underline">Buka Halaman Pengaturan</a>
                <a href="#" class="block py-2 text-on-background hover:underline">Opsi Lainnya (coming soon)</a>
            </div>
        </div>
    </div>
@elseif($settingsMode === 'dropdown')
    <div class="relative">
        <button id="headerSettingsBtn" type="button" class="text-on-surface-variant hover:text-tertiary transition-colors p-2 rounded-full" title="Pengaturan">
            <span class="material-symbols-outlined">settings</span>
        </button>
        <div id="settingsDropdown" class="hidden absolute right-0 mt-2 w-44 bg-surface-container-lowest rounded shadow-lg border border-outline-variant/20">
            @foreach(config('admin.dropdown_links', []) as $link)
                @php
                    $href = '#';
                    try {
                        if(\Illuminate\Support\Facades\Route::has($link['route'])){
                            $href = route($link['route']);
                        }
                    } catch (\Throwable $e) {
                        $href = '#';
                    }
                @endphp
                <a href="{{ $href }}" class="block px-4 py-2 text-on-background hover:bg-surface-container-high">{{ $link['label'] }}</a>
            @endforeach

            <div class="border-t border-outline-variant/10"></div>
            <button id="adminLogoutBtn" class="w-full text-left px-4 py-2 text-on-background hover:bg-surface-container-high">Keluar</button>
            <form id="adminLogoutForm" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
        </div>
    </div>
@else
    <a id="headerSettingsBtn" href="{{ route('admin.settings') }}" class="text-on-surface-variant hover:text-tertiary transition-colors p-2 rounded-full" title="Pengaturan">
        <span class="material-symbols-outlined">settings</span>
    </a>
@endif
<div class="w-10 h-10 rounded-full border-2 border-outline-variant/30 overflow-hidden cursor-pointer hover:border-tertiary transition-colors bg-secondary-container flex items-center justify-center shrink-0" title="{{ auth()->user()->name }}">
<span class="font-headline-md text-body-md text-on-secondary-container">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
</div>
</div>
</header>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const adminHeaderEl = document.getElementById('adminHeader');
        const mode = adminHeaderEl ? adminHeaderEl.dataset.settingsMode : 'link';
        if(mode === 'modal'){
            const btn = document.getElementById('headerSettingsBtn');
            const modal = document.getElementById('settingsModal');
            const close = document.getElementById('settingsClose');
            if(btn && modal){
                btn.addEventListener('click', () => modal.classList.remove('hidden'));
                close && close.addEventListener('click', () => modal.classList.add('hidden'));
                modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.add('hidden'); });
            }
        } else if(mode === 'dropdown'){
            const btn = document.getElementById('headerSettingsBtn');
            const dropdown = document.getElementById('settingsDropdown');
                if(btn && dropdown){
                    btn.addEventListener('click', (e) => { e.preventDefault(); dropdown.classList.toggle('hidden'); });
                    document.addEventListener('click', (e) => { if(!btn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden'); });

                    // logout handler
                    const logoutBtn = document.getElementById('adminLogoutBtn');
                    const logoutForm = document.getElementById('adminLogoutForm');
                    if(logoutBtn && logoutForm){
                        logoutBtn.addEventListener('click', (e) => { e.preventDefault(); logoutForm.submit(); });
                    }
                }
        }
    });
</script>
@endpush
