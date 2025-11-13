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
                    Privacidad de Datos
                </h2>
                <p class="mt-1 text-sm text-[var(--text-muted)]">
                    Política de protección de datos personales
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
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-[var(--text)]">Política de Privacidad</h1>
                            <p class="text-sm text-[var(--text-muted)] mt-1">
                                Última actualización: {{ date('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="px-6 sm:px-8 py-8 prose prose-sm max-w-none">
                    <div class="space-y-6">
                        <!-- Introducción -->
                        <div class="p-4 rounded-lg bg-[var(--accent)]/10 border border-[var(--accent)]/30">
                            <p class="text-sm text-[var(--text-secondary)] leading-relaxed">
                                En FESC nos comprometemos a proteger la privacidad y seguridad de los datos personales
                                de nuestros usuarios, en cumplimiento con la Ley 1581 de 2012 de Protección de Datos
                                Personales de Colombia.
                            </p>
                        </div>

                        <!-- Sección 1 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    1
                                </span>
                                Información que Recopilamos
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-3">
                                <p>Recopilamos la siguiente información:</p>

                                <div class="space-y-2">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-[var(--text)]">Datos de Identificación</p>
                                            <p class="text-sm">Nombre completo, correo institucional, número de
                                                identificación</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-[var(--text)]">Datos de Acceso</p>
                                            <p class="text-sm">Dirección IP, fechas y horas de acceso, navegador
                                                utilizado</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-[var(--text)]">Datos de Uso</p>
                                            <p class="text-sm">Actividades realizadas en el sistema, preferencias de
                                                configuración</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Sección 2 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    2
                                </span>
                                Uso de la Información
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-2">
                                <p>Utilizamos su información para:</p>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Proporcionar acceso y funcionalidad del sistema</li>
                                    <li>Gestionar procesos administrativos y académicos</li>
                                    <li>Mejorar la experiencia de usuario</li>
                                    <li>Garantizar la seguridad del sistema</li>
                                    <li>Cumplir con obligaciones legales y regulatorias</li>
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
                                Protección de Datos
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-2">
                                <p>Implementamos medidas de seguridad para proteger su información:</p>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Encriptación de datos sensibles</li>
                                    <li>Control de acceso basado en roles</li>
                                    <li>Auditorías de seguridad periódicas</li>
                                    <li>Respaldos automáticos de información</li>
                                    <li>Protocolos de seguridad SSL/TLS</li>
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
                                Derechos del Titular
                            </h2>
                            <div class="text-[var(--text-secondary)] leading-relaxed space-y-2">
                                <p>Usted tiene derecho a:</p>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Conocer, actualizar y rectificar sus datos personales</li>
                                    <li>Solicitar prueba de la autorización otorgada</li>
                                    <li>Ser informado sobre el uso de sus datos</li>
                                    <li>Presentar quejas ante la Superintendencia de Industria y Comercio</li>
                                    <li>Revocar la autorización y/o solicitar la supresión del dato</li>
                                </ul>
                            </div>
                        </section>

                        <!-- Sección 5 -->
                        <section>
                            <h2 class="text-xl font-bold text-[var(--text)] mb-3 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-[var(--accent)]/10 flex items-center justify-center text-[var(--accent)] text-sm font-bold">
                                    5
                                </span>
                                Compartir Información
                            </h2>
                            <p class="text-[var(--text-secondary)] leading-relaxed">
                                No compartimos su información personal con terceros, excepto cuando sea necesario para
                                cumplir con obligaciones legales o cuando usted haya dado su consentimiento explícito.
                            </p>
                        </section>

                        <!-- Aviso de contacto -->
                        {{-- <div
                            class="mt-8 p-4 rounded-lg border border-[var(--border)] bg-gradient-to-br from-[var(--border)]/5 to-transparent">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-[var(--accent)] shrink-0 mt-0.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-[var(--text)] mb-1">
                                        ¿Tiene preguntas sobre sus datos?
                                    </p>

                                    <p class="text-xs text-[var(--text-secondary)] leading-relaxed">
                                        Para ejercer sus derechos o presentar consultas sobre el tratamiento de datos
                                        personales,
                                        contacte a nuestro oficial de protección de datos en:
                                        <a href="mailto:protecciondatos@fesc.edu.co"
                                            class="text-[var(--accent)] hover:underline font-medium">
                                            protecciondatos@fesc.edu.co
                                        </a>
                                    </p>

                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Footer del documento -->
                <div class="px-6 sm:px-8 py-4 border-t border-[var(--border)] bg-[var(--border)]/5">
                    <p class="text-xs text-[var(--text-secondary)] text-center">
                        FESC se reserva el derecho de actualizar esta política. Los cambios serán notificados
                        oportunamente.
                    </p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>
