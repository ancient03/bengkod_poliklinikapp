<header class="bg-base-100 border-b border-base-300 h-16 flex items-center px-6 gap-4 sticky top-0 z-30 shadow-sm">

    {{-- Mobile Hamburger --}}
    <button onclick="toggleSidebar()" class="btn btn-square btn-ghost lg:hidden">
        <i class="fas fa-bars text-base"></i>
    </button>

    {{-- Breadcrumb --}}
    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-base-content/50">Poliklinik</span>
            <i class="fas fa-chevron-right text-xs text-base-content/30"></i>
            <span class="font-semibold text-base-content">
                {{ $title ?? 'Dashboard' }}
            </span>
        </div>
    </div>

    {{-- Fullscreen --}}
    <button onclick="toggleFullscreen()" class="btn btn-square btn-ghost">
        <i id="fsIcon" class="fas fa-expand w-5 h-5"></i>
    </button>

    {{-- User Info --}}
    @if (auth()->check())
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button"
                class="flex items-center gap-3 cursor-pointer p-1.5 rounded-xl hover:bg-base-200/60 transition-colors">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-semibold leading-tight text-base-content">
                        {{ auth()->user()->nama ?? (auth()->user()->name ?? 'Pengguna') }}
                    </div>
                    <div class="text-xs text-base-content/60 leading-tight capitalize mt-0.5">
                        {{ auth()->user()->role ?? '' }}
                        @if (auth()->user()->role === 'pasien' && auth()->user()->no_rm)
                            <span class="text-base-content/40">• {{ auth()->user()->no_rm }}</span>
                        @endif
                    </div>
                </div>

                <div class="avatar placeholder">
                    <div
                        class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-primary/20">
                        <span>
                            {{ strtoupper(substr(auth()->user()->nama ?? (auth()->user()->name ?? 'U'), 0, 1)) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    @endif

</header>

<script>
    function toggleFullscreen() {
        const icon = document.getElementById('fsIcon');

        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            icon.classList.remove('fa-expand');
            icon.classList.add('fa-compress');
        } else {
            document.exitFullscreen();
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
        }
    }
</script>
