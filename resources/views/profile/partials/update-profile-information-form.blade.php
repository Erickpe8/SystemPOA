<section x-data="{ openConfirm() { window.dispatchEvent(new CustomEvent('open-confirm-saveProfile')) } }" class="theme-text">
    <!-- Encabezado -->
    <header class="mb-4">
        <h2 class="text-2xl font-bold text-[var(--accent)]">Información del perfil</h2>
        <p class="mt-1 text-sm text-[color:var(--text)]/70">
            Actualiza tu nombre y correo institucional. Si es necesario, te enviaremos verificación por correo.
        </p>
    </header>

    <!-- Form verificación -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <!-- SIN card / SIN borde: grid de ancho completo -->
    <form x-ref="form" method="post" action="{{ route('profile.update') }}" @submit.prevent="openConfirm()">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div class="col-span-1">
                <label for="name" class="block w-full font-semibold text-[var(--text)]">Nombre completo</label>
                <x-text-input id="name" name="name" type="text"
                    class="mt-2 block w-full
                           bg-[var(--bg)] text-[var(--text)]
                           border border-[color:var(--border)]
                           placeholder:text-[color:var(--text)]/50
                           focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]"
                    value="{{ old('name', $user->name) }}" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="col-span-1">
                <label for="email" class="block w-full font-semibold text-[var(--text)]">Correo institucional</label>
                <x-text-input id="email" name="email" type="email"
                    class="mt-2 block w-full
                           bg-[var(--bg)] text-[var(--text)]
                           border border-[color:var(--border)]
                           placeholder:text-[color:var(--text)]/50
                           focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]"
                    value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-[color:var(--text)]/80">
                            Tu dirección de correo no ha sido verificada.
                            <button form="send-verification"
                                class="ml-1 underline text-[color:var(--text)]/80 hover:text-[var(--accent)]
                                       rounded focus:outline-none focus:ring-2 focus:ring-[var(--accent)]">
                                Reenviar enlace
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-emerald-500">
                                Enviamos un nuevo enlace de verificación.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones (sin cajas extras) -->
        <div class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
                           font-semibold bg-[var(--accent)] text-white hover:bg-[var(--primary)]
                           focus:outline-none focus:ring-2 focus:ring-[var(--accent)]">
                Guardar cambios
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-sm text-[color:var(--text)]/70">Guardado.</span>
            @endif
        </div>
    </form>

    <!-- Modal de confirmación reutilizable -->
    <x-confirm-dialog id="saveProfile" title="¿Confirmar guardado?" message="Se actualizará tu información de perfil."
        confirmText="Sí, guardar" cancelText="Cancelar" icon="info" confirmEvent="profile-save" />

    @push('scripts')
        <script>
            // Submit real al confirmar
            window.addEventListener('profile-save', () => {
                document.querySelector('section[x-data]')?.querySelector('form[x-ref="form"]')?.submit();
            });

            // Notificaciones
            document.addEventListener('DOMContentLoaded', () => {
                @if (session('status') === 'profile-updated')
                    if (typeof showNotification === 'function') {
                        showNotification('Perfil actualizado correctamente.', 'success');
                    }
                @endif
                @if ($errors->any())
                    if (typeof showNotification === 'function') {
                        showNotification('Revisa los campos del formulario.', 'error');
                    }
                @endif
            });
        </script>
    @endpush
</section>
