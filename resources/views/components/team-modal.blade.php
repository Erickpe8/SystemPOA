<div x-data="{ show: false }" @open-team-modal.window="show = true" @close.stop="show = false"
    @keydown.escape.window="show = false" x-show="show" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">

    <!-- Overlay -->
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="show = false">
    </div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-[var(--card)] rounded-xl shadow-2xl border border-[var(--border)]
                    w-full max-w-2xl overflow-hidden"
            @click.away="show = false">

            <!-- Header -->
            <div
                class="relative px-6 py-5 border-b border-[var(--border)]
                        bg-gradient-to-r from-[var(--primary)]/10 to-[var(--accent)]/5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                    flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[var(--text)]">
                                Equipo de Desarrollo
                            </h3>
                            <p class="text-xs text-[var(--text-muted)] mt-0.5">
                                Personas detrás de SystemPOA
                            </p>
                        </div>
                    </div>
                    <button @click="show = false"
                        class="text-[var(--text)]/50 hover:text-[var(--accent)] transition-colors
                                   p-2 rounded-lg hover:bg-[var(--border)]/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6 max-h-[60vh] overflow-y-auto">
                <div class="space-y-4">
                    <!-- Miembro 1 -->
                    <div
                        class="group p-4 rounded-lg border border-[var(--border)]
                                hover:border-[var(--accent)]/50 transition-all duration-200
                                hover:shadow-lg bg-gradient-to-br from-[var(--border)]/5 to-transparent">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                        flex items-center justify-center text-white font-bold text-lg shadow-md
                                        group-hover:scale-110 transition-transform duration-200">
                                SR
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="font-bold text-[var(--text)] group-hover:text-[var(--accent)] transition-colors">
                                    Santiago Rueda Quintero
                                </h4>
                                <p class="text-sm text-[var(--accent)] font-medium">
                                    Desarrollador Full Stack
                                </p>
                                <p class="text-xs text-[var(--text-muted)] mt-2 leading-relaxed">
                                    Arquitectura del sistema, desarrollo backend (Laravel) y frontend (Blade, TailwindCSS).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Miembro 2 -->
                    <div
                        class="group p-4 rounded-lg border border-[var(--border)]
                                hover:border-[var(--accent)]/50 transition-all duration-200
                                hover:shadow-lg bg-gradient-to-br from-[var(--border)]/5 to-transparent">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                        flex items-center justify-center text-white font-bold text-lg shadow-md
                                        group-hover:scale-110 transition-transform duration-200">
                                SP
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="font-bold text-[var(--text)] group-hover:text-[var(--accent)] transition-colors">
                                    ERICK SEBASTIAN PEREZ CARVAJAL
                                </h4>
                                <p class="text-sm text-[var(--accent)] font-medium">
                                    Desarrollador Full Stack
                                </p>
                                <p class="text-xs text-[var(--text-muted)] mt-2 leading-relaxed">
                                    Arquitectura del sistema, desarrollo backend (Laravel) y frontend (Blade, TailwindCSS).                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Miembro 3 -->
                    <div
                        class="group p-4 rounded-lg border border-[var(--border)]
                                hover:border-[var(--accent)]/50 transition-all duration-200
                                hover:shadow-lg bg-gradient-to-br from-[var(--border)]/5 to-transparent">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                        flex items-center justify-center text-white font-bold text-lg shadow-md
                                        group-hover:scale-110 transition-transform duration-200">
                                YR
                            </div>
                            <div class="flex-1">
                                <h4
                                    class="font-bold text-[var(--text)] group-hover:text-[var(--accent)] transition-colors">
                                    YEISON EDUARD ROLON ORTIZ
                                </h4>
                                <p class="text-sm text-[var(--accent)] font-medium">
                                    Apoyo Unidad De Desarrollo
                                </p>
                                <p class="text-xs text-[var(--text-muted)] mt-2 leading-relaxed">
                                    Documentación.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Agradecimientos -->
                    <div class="mt-6 p-4 rounded-lg bg-[var(--border)]/10 border border-[var(--border)]/30">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-[var(--text)] mb-1">
                                    Agradecimientos especiales
                                </p>
                                <p class="text-xs text-[var(--text-muted)] leading-relaxed">
                                    A la Fundación de Estudios Superiores Comfanorte (FESC) por su apoyo y confianza en
                                    este proyecto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-[var(--border)] bg-[var(--border)]/5">
                <button @click="show = false"
                    class="w-full px-4 py-2.5 rounded-lg font-semibold
                               bg-[var(--accent)] text-white
                               hover:bg-[var(--primary)] transition-all duration-200
                               focus:outline-none focus:ring-2 focus:ring-[var(--accent)]">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
