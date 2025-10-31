<nav
    x-cloak
    class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1D1616] text-[#EEEEEE] border-r border-[#8E1616]/40
           transform transition-transform duration-200 -translate-x-full lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen }"
>
    <!-- Header / Logo institucional -->
    <div class="h-20 flex flex-col items-center justify-center border-b border-[#8E1616]/50 px-4 py-3">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center">
            <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC" class="h-12 w-auto mb-1">
            <span class="text-lg font-bold text-[#D84040] tracking-wide">SystemPOA</span>
        </a>
    </div>
    
    <button id="themeToggle"
            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-[color:var(--border)]
                hover:bg-[var(--accent)]/20 transition text-sm"
            aria-pressed="false" aria-label="Cambiar tema">
        <svg id="iconSun"  class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v2m0 12v2m8-8h-2M6 12H4m12.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
        </svg>
        <svg id="iconMoon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
        </svg>
        <span class="font-semibold">Tema</span>
    </button>

    <!-- Información del usuario -->
    <div class="flex flex-col items-center py-4 border-b border-[#8E1616]/50">
        <div class="text-center">
            <p class="font-semibold text-[#EEEEEE] text-sm">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[#D84040] font-medium capitalize mt-1">
                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
            </p>
        </div>
    </div>

    <!-- Sección principal -->
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-2">
        <p class="uppercase text-xs tracking-widest text-[#D84040] mb-2">Principal</p>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                   text-[#EEEEEE] hover:bg-[#8E1616]/70 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#D84040]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
            </svg>
            {{ __('Dashboard') }}
        </x-nav-link>

        <!-- Espacio reservado para futuras áreas -->
        <hr class="my-3 border-[#8E1616]/40">
        <p class="uppercase text-xs tracking-widest text-[#D84040] mb-2">Módulos</p>
        <p class="text-xs text-[#EEEEEE]/70 italic">Próximamente...</p>
    </div>

    <!-- Sección inferior: Perfil y Cierre de sesión -->
    <div class="border-t border-[#8E1616]/40 p-3">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="w-full inline-flex items-center justify-between gap-2 px-3 py-2 rounded-md
                           text-sm font-medium bg-[#8E1616]/20 hover:bg-[#8E1616]/40 text-[#EEEEEE] transition">
                    <span class="truncate">{{ __('Cuenta') }}</span>
                    <svg class="h-4 w-4 text-[#D84040]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-[#D84040] hover:text-[#8E1616]">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
