<nav
    x-cloak
    class="fixed inset-y-0 left-0 z-40 w-64
        bg-[var(--card)] text-[var(--text)] border-r border-[color:var(--border)]
        transform transition-transform duration-200 -translate-x-full lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen }"
>
    <!-- Header / Logo + Theme toggle -->
    <div class="h-16 px-4 flex items-center justify-between border-b border-[color:var(--border)]">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 group">
            <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC" class="h-8 w-auto" />
        </a>
        {{-- Switch de tema (sin JS extra; ya lo montamos en el componente) --}}
        <x-theme-toggle id="theme-toggle-side" size="md" />
    </div>

    <!-- Usuario -->
    <div class="px-4 py-4 border-b border-[color:var(--border)]">
        <div class="text-center">
            <p class="font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[var(--accent)] font-medium capitalize mt-1 truncate">
                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
            </p>
        </div>
    </div>

    <!-- Navegación -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-3">
        <div>
            <p class="uppercase text-[10px] tracking-[0.15em] text-[color:var(--text)]/60 px-1 mb-2">Principal</p>

            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    hover:bg-[color:var(--border)]/20 transition">
                {{-- Home icon (Heroicons outline) --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[var(--accent)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                <span>Dashboard</span>
            </x-nav-link>
        </div>

        <!-- Módulos (espacio reservado) -->
        <div class="pt-2">
            <p class="uppercase text-[10px] tracking-[0.15em] text-[color:var(--text)]/60 px-1 mb-2">Módulos</p>
            <div class="px-3 py-2 rounded-lg text-xs italic bg-[color:var(--border)]/10 text-[color:var(--text)]/70">
                Próximamente…
            </div>
        </div>
    </div>

    <!-- Footer: Cuenta / Cerrar sesión (sticky) -->
    <div class="border-t border-[color:var(--border)] p-3">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="w-full inline-flex items-center justify-between gap-2 px-3 py-2 rounded-md
                        text-sm font-medium bg-[color:var(--border)]/15 hover:bg-[color:var(--border)]/25 transition">
                    <span class="truncate">Cuenta</span>
                    <svg class="h-4 w-4 text-[var(--accent)]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    Perfil
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-[var(--accent)] hover:text-[var(--primary)]">
                        Cerrar sesión
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
