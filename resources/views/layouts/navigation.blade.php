<nav x-cloak x-data="{ userManagementOpen: false }"
    class="fixed inset-y-0 left-0 z-40 w-64
        bg-[var(--card)] text-[var(--text)] border-r border-[var(--border)]
        transform transition-transform duration-200 -translate-x-full lg:translate-x-0
        backdrop-blur-sm"
    :class="{ 'translate-x-0': sidebarOpen }">
    <!-- Header / Logo + Theme toggle -->
    <div
        class="h-16 px-4 flex items-center justify-between border-b border-[var(--border)]
                bg-gradient-to-r from-[var(--primary)]/5 to-transparent">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 group">
            <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC"
                class="h-8 w-auto transition-transform duration-300 group-hover:scale-105" />
        </a>
        {{-- Switch de tema --}}
        <x-theme-toggle id="theme-toggle-side" size="md" />
    </div>

    <!-- Usuario -->
    <div class="px-4 py-4 border-b border-[var(--border)]">
        <div
            class="p-3 rounded-lg bg-gradient-to-br from-[var(--primary)]/10 to-[var(--accent)]/5
                    border border-[var(--border)] text-center
                    hover:from-[var(--primary)]/15 hover:to-[var(--accent)]/10 transition-all duration-300">
            <p class="font-semibold text-sm truncate text-[var(--text)]">
                {{ Auth::user()->name }}
            </p>
            <p class="text-xs text-[var(--accent)] font-medium capitalize mt-1 truncate">
                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
            </p>
        </div>
    </div>

    <!-- Navegación -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-3">
        <div>
            <p class="uppercase text-[10px] tracking-[0.15em] text-[var(--text)]/50 px-3 mb-2 font-bold">
                Principal
            </p>

            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                    transition-all duration-200 group
                    {{ request()->routeIs('dashboard')
                        ? 'bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] text-white shadow-lg'
                        : 'hover:bg-[var(--border)]/20 text-[var(--text)]' }}">
                {{-- Home icon --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 transition-transform duration-200 group-hover:scale-110
                            {{ request()->routeIs('dashboard') ? 'text-white' : 'text-[var(--accent)]' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </x-nav-link>
        </div>

        {{-- ==========================================
            CONTROL DE USUARIOS (Solo SuperAdmin)
        ========================================== --}}
        @if(Auth::user()->hasRole('superadmin'))
            <div class="pt-2">
                <p class="uppercase text-[10px] tracking-[0.15em] text-[var(--text)]/50 px-3 mb-2 font-bold">
                    Administración
                </p>

                {{-- Dropdown de Control de Usuarios --}}
                <div class="relative">
                    <button
                        @click="userManagementOpen = !userManagementOpen"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                            transition-all duration-200 group
                            {{ request()->routeIs('user-management.*')
                                ? 'bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] text-white shadow-lg'
                                : 'hover:bg-[var(--border)]/20 text-[var(--text)]' }}">
                        <div class="flex items-center gap-3">
                            {{-- Users icon --}}
                            <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110
                                    {{ request()->routeIs('user-management.*') ? 'text-white' : 'text-[var(--accent)]' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Control de Usuarios</span>
                        </div>
                        {{-- Chevron --}}
                        <svg class="w-4 h-4 transition-transform duration-200"
                            :class="{ 'rotate-180': userManagementOpen }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Submenu --}}
                    <div x-show="userManagementOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="mt-2 ml-3 space-y-1 border-l-2 border-[var(--border)] pl-3">

                        {{-- Panel Principal --}}
                        <a href="{{ route('user-management.index') }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm
                                transition-all duration-200 group
                                {{ request()->routeIs('user-management.index')
                                    ? 'bg-[var(--primary)]/10 text-[var(--primary)] font-medium'
                                    : 'hover:bg-[var(--border)]/10 text-[var(--text)]/70' }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span>Panel de Control</span>
                        </a>

                        {{-- Badge de Pendientes --}}
                        @php
                            $pendingCount = \App\Models\User::where('is_active', false)->count();
                        @endphp
                        @if($pendingCount > 0)
                            <div class="px-3 py-2 rounded-lg bg-yellow-500/10 border border-yellow-500/20">
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                    <span class="text-yellow-600 dark:text-yellow-400 font-medium">
                                        {{ $pendingCount }} solicitud{{ $pendingCount > 1 ? 'es' : '' }} pendiente{{ $pendingCount > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Módulos -->
        <div class="pt-2">
            <p class="uppercase text-[10px] tracking-[0.15em] text-[var(--text)]/50 px-3 mb-2 font-bold">
                Módulos
            </p>
            <div
                class="mx-3 px-3 py-3 rounded-lg text-xs italic
                        bg-gradient-to-br from-[var(--border)]/10 to-transparent
                        border border-[var(--border)]/30
                        text-[var(--text)]/60">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[var(--accent)]/50" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Próximamente…</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer: Cuenta / Cerrar sesión -->
    <div
        class="border-t border-[var(--border)] p-3
                bg-gradient-to-t from-[var(--primary)]/5 to-transparent">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="w-full inline-flex items-center justify-between gap-2 px-3 py-2.5 rounded-lg
                        text-sm font-medium transition-all duration-200
                        bg-gradient-to-r from-[var(--border)]/15 to-[var(--border)]/5
                        hover:from-[var(--primary)]/20 hover:to-[var(--accent)]/10
                        border border-[var(--border)]/30 hover:border-[var(--accent)]/30
                        group">
                    <span class="truncate text-[var(--text)]">Cuenta</span>
                    <svg class="h-4 w-4 text-[var(--accent)] transition-transform duration-200 group-hover:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 group">
                    <svg class="w-4 h-4 text-[var(--accent)] transition-transform duration-200 group-hover:scale-110"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Perfil</span>
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-[var(--accent)] hover:text-white hover:bg-[var(--primary)]
                               flex items-center gap-2 group transition-all">
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Cerrar sesión</span>
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
