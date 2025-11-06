<footer class="bg-[var(--card)] border-t border-[var(--border)] mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Columna 1: Sobre el sistema -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC" class="h-8 w-auto" />
                    <span class="font-bold text-[var(--text)]">SystemPOA</span>
                </div>
                <p class="text-sm text-[var(--text)]/60 leading-relaxed">
                    Sistema de gestión institucional desarrollado para optimizar procesos administrativos y académicos.
                </p>
            </div>

            <!-- Columna 2: Enlaces legales -->
            <div>
                <h3 class="font-bold text-[var(--text)] mb-4 text-sm uppercase tracking-wide">
                    Legal
                </h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('legal.terms') }}"
                            class="text-sm text-[var(--text)]/70 hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Política del Sistema
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.privacy') }}"
                            class="text-sm text-[var(--text)]/70 hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Privacidad de Datos
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Columna 3: Equipo -->
            <div>
                <h3 class="font-bold text-[var(--text)] mb-4 text-sm uppercase tracking-wide">
                    Información
                </h3>
                <button @click="$dispatch('open-team-modal')"
                    class="text-sm text-[var(--text)]/70 hover:text-[var(--accent)] transition-colors inline-flex items-center gap-1.5 group">
                    <svg class="w-4 h-4 text-[var(--accent)]/50 group-hover:text-[var(--accent)] transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Equipo de Desarrollo
                </button>
            </div>
        </div>
    </div>

    <!-- Modal del equipo de desarrollo -->
    <x-team-modal />
</footer>
