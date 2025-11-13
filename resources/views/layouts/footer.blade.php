<footer class="bg-[var(--card)] border-t border-[var(--border)] mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Layout Principal: Logo a la izquierda, enlaces al centro/derecha -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

            <!-- Logo y nombre -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC" class="h-7 w-auto" />
                <span class="font-bold text-[var(--text)] text-sm">SystemPOA</span>
            </div>

            <!-- Enlaces en línea horizontal -->
            <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                <!-- Legal -->
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider hidden sm:inline">
                        Legal
                    </span>
                    <a href="{{ route('legal.terms') }}"
                        class="text-sm text-[var(--text-secondary)] hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                        <svg class="w-3.5 h-3.5 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Política del Sistema
                    </a>

                    <span class="text-[var(--text-muted)]">|</span>

                    <a href="{{ route('legal.privacy') }}"
                        class="text-sm text-[var(--text-secondary)] hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                        <svg class="w-3.5 h-3.5 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Privacidad de Datos
                    </a>
                </div>

                <!-- Separador vertical -->
                <span class="hidden md:inline text-[var(--text-muted)]">•</span>

                <!-- Información -->
                <div class="flex items-center gap-4">
                    <span class="text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wider hidden sm:inline">
                        Información
                    </span>
                    <button @click="$dispatch('open-team-modal')"
                        class="text-sm text-[var(--text-secondary)] hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                        <svg class="w-3.5 h-3.5 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Equipo de Desarrollo
                    </button>
                </div>
            </nav>
        </div>
    </div>

    <!-- Modal del equipo de desarrollo -->
    <x-team-modal />
</footer>
