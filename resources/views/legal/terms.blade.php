<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-[var(--text-muted)] hover:text-[var(--accent)] transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-2xl text-[var(--text)] leading-tight">
                    Política del Sistema
                </h2>
                <p class="mt-1 text-sm text-[var(--text-muted)]">
                    Términos y condiciones de uso de SystemPOA
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10 bg-[var(--bg)] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-[var(--card)] rounded-xl border border-[var(--border)] shadow-lg overflow-hidden">
                <!-- Header del documento -->
                <div
                    class="px-6 sm:px-8 py-6 border-b border-[var(--border)] bg-gradient-to-r from-[var(--primary)]/5 to-transparent">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-lg bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                    flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-[var(--text)]">Política del Sistema</h1>
                            <p class="text-sm text-[var(--text-muted)] mt-1">
                                Última actualización: {{ date('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="px-6 sm:px-8 py-8 prose prose-sm max-w-none">
                    <div class="space-y-6">
                        <!-- Sección 1 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    1
                                </span>
                                Aceptación de Términos
                            </h2>
                            <p class="text-[var(--text-secondary)] leading-relaxed">
                                Al acceder y utilizar SystemPOA, usted acepta cumplir con estos términos y condiciones.
                                Este sistema está diseñado exclusivamente para uso institucional dentro de la Fundación
                                de
                                Estudios Superiores Comfanorte (FESC).
                            </p>
                        </section>

                        <!-- Sección 2 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    2
                                </span>
                                Uso Autorizado
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-2">
                                <p>El sistema está destinado únicamente para:</p>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Gestión de procesos administrativos institucionales</li>
                                    <li>Consulta de información académica autorizada</li>
                                    <li>Ejecución de tareas relacionadas con su rol asignado</li>
                                </ul>
                            </div>
                        </section>

                        <!-- Sección 3 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    3
                                </span>
                                Responsabilidades del Usuario
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-2">
                                <p>Los usuarios se comprometen a:</p>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Mantener la confidencialidad de sus credenciales de acceso</li>
                                    <li>No compartir información sensible fuera del sistema</li>
                                    <li>Utilizar el sistema de manera ética y profesional</li>
                                    <li>Reportar cualquier irregularidad o problema de seguridad</li>
                                </ul>
                            </div>
                        </section>

                        <!-- Sección 4 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    4
                                </span>
                                Propiedad Intelectual
                            </h2>
                            <p class="text-[var(--text-secondary)] leading-relaxed">
                                SystemPOA y todo su contenido son propiedad exclusiva de FESC. Queda prohibida la
                                reproducción, distribución o uso no autorizado del sistema, su código fuente o cualquier
                                componente del mismo.
                            </p>
                        </section>

                        <!-- Sección 5 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    5
                                </span>
                                Limitación de Responsabilidad
                            </h2>
                            <p class="text-[var(--text-secondary)] leading-relaxed">
                                FESC no será responsable por interrupciones del servicio, pérdida de datos o cualquier
                                daño derivado del uso del sistema, excepto en casos de negligencia comprobada.
                            </p>
                        </section>

                        <!-- Aviso importante -->
                        <div class="mt-8 p-4 rounded-lg bg-[var(--accent)]/10 border border-[var(--accent)]/30">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-[var(--accent)] mb-1">
                                        Importante
                                    </p>
                                    <p class="text-xs text-[var(--text-secondary)] leading-relaxed">
                                        El incumplimiento de estas políticas puede resultar en la suspensión o
                                        cancelación
                                        de su cuenta y acciones legales según corresponda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer del documento -->
                <div class="px-6 sm:px-8 py-4 border-t border-[var(--border)] bg-[var(--border)]/5">
                    <p class="text-xs text-[var(--text-secondary)] text-center">
                        Para consultas sobre estas políticas, contacte al administrador del sistema.
                    </p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
