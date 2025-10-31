<section x-data="{
    showCur: false,
    showNew: false,
    showConf: false,
    openConfirm() { window.dispatchEvent(new CustomEvent('open-confirm-updatePassword')) }
}" class="theme-text">
    <!-- Encabezado -->
    <header class="mb-4">
        <h2 class="text-2xl font-bold text-[var(--accent)]">Actualizar contraseña</h2>
        <p class="mt-1 text-sm text-[color:var(--text)]/70">
            Primero confirma tu contraseña actual. Luego ingresa la nueva y su confirmación.
        </p>
    </header>

    <!-- Formulario (ancho completo, sin card) -->
    <form x-ref="formPw" method="post" action="{{ route('password.update') }}" @submit.prevent="openConfirm()"
        class="space-y-8">
        @csrf
        @method('put')

        <!-- 1) Contraseña actual -->
        <div>
            <label for="update_password_current_password" class="block font-semibold text-[var(--text)] text-base">
                Contraseña actual
            </label>

            <div class="mt-2 relative">
                <x-text-input id="update_password_current_password" name="current_password"
                    x-bind:type="showCur ? 'text' : 'password'" autocomplete="current-password"
                    class="block w-full pr-12
                           bg-[var(--bg)] text-[var(--text)]
                           border border-[color:var(--border)]
                           placeholder:text-[color:var(--text)]/50
                           focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]" />

                <!-- Toggle show/hide -->
                <button type="button"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-[color:var(--text)]/70 hover:text-[var(--text)]"
                    x-on:click="showCur = !showCur" x-bind:aria-pressed="showCur.toString()">
                    <svg x-show="!showCur" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showCur" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.307-3.78M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.132 5.225M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- Separador visual ligero -->
        <hr class="border-[color:var(--border)]/60">

        <!-- 2) Nueva contraseña (stack: nueva > confirmar) -->
        <div class="space-y-6">
            <div>
                <label for="update_password_password" class="block font-semibold text-[var(--text)] text-base">
                    Nueva contraseña
                </label>

                <div class="mt-2 relative">
                    <x-text-input id="update_password_password" name="password"
                        x-bind:type="showNew ? 'text' : 'password'" autocomplete="new-password"
                        class="block w-full pr-12
                               bg-[var(--bg)] text-[var(--text)]
                               border border-[color:var(--border)]
                               placeholder:text-[color:var(--text)]/50
                               focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]" />

                    <button type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-[color:var(--text)]/70 hover:text-[var(--text)]"
                        x-on:click="showNew = !showNew" x-bind:aria-pressed="showNew.toString()">
                        <svg x-show="!showNew" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showNew" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.307-3.78M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.132 5.225M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                <p class="mt-1 text-xs text-[color:var(--text)]/60">
                    Usa al menos 8 caracteres y combina letras, números y símbolos.
                </p>
            </div>

            <div>
                <label for="update_password_password_confirmation"
                    class="block font-semibold text-[var(--text)] text-base">
                    Confirmar nueva contraseña
                </label>

                <div class="mt-2 relative">
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                        x-bind:type="showConf ? 'text' : 'password'" autocomplete="new-password"
                        class="block w-full pr-12
                               bg-[var(--bg)] text-[var(--text)]
                               border border-[color:var(--border)]
                               placeholder:text-[color:var(--text)]/50
                               focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]" />

                    <button type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-[color:var(--text)]/70 hover:text-[var(--text)]"
                        x-on:click="showConf = !showConf" x-bind:aria-pressed="showConf.toString()">
                        <svg x-show="!showConf" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConf" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.307-3.78M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-4.132 5.225M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Acciones -->
        <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg
                           font-semibold bg-[var(--accent)] text-white hover:bg-[var(--primary)]
                           focus:outline-none focus:ring-2 focus:ring-[var(--accent)]">
                Guardar nueva contraseña
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-sm text-[color:var(--text)]/70">Actualizada.</span>
            @endif
        </div>
    </form>

    <!-- Confirmación reutilizable -->
    <x-confirm-dialog id="updatePassword" title="¿Actualizar contraseña?"
        message="Se aplicarán los cambios de contraseña para tu cuenta." confirmText="Sí, actualizar"
        cancelText="Cancelar" icon="warning" confirmEvent="password-save" />

    @push('scripts')
        <script>
            // Envío real tras confirmar
            window.addEventListener('password-save', () => {
                document.querySelector('section[x-data]')?.querySelector('form[x-ref="formPw"]')?.submit();
            });

            // Notificación global
            document.addEventListener('DOMContentLoaded', () => {
                @if (session('status') === 'password-updated')
                    if (typeof showNotification === 'function') {
                        showNotification('Contraseña actualizada correctamente.', 'success');
                    }
                @endif
                @if ($errors->updatePassword->any())
                    if (typeof showNotification === 'function') {
                        showNotification('No fue posible actualizar la contraseña. Revisa los campos.', 'error');
                    }
                @endif
            });
        </script>
    @endpush
</section>
