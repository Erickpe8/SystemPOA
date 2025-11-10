<section x-data="{
    loading: false,
    initialName: '{{ old('name', $user->name) }}',
    initialEmail: '{{ old('email', $user->email) }}',
    currentName: '{{ old('name', $user->name) }}',
    currentEmail: '{{ old('email', $user->email) }}',

    get hasChanges() {
        return this.currentName !== this.initialName || this.currentEmail !== this.initialEmail;
    }
}">
    <!-- Encabezado -->
    <header class="mb-6">
        <h2 class="text-2xl font-bold theme-text">Información del perfil</h2>
        <p class="mt-1 text-sm text-[color:var(--muted)]">
            Actualiza tu nombre y correo institucional.
        </p>
    </header>

    <!-- Form verificación -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <!-- Formulario principal -->
    <form method="post" action="{{ route('profile.update') }}" @submit="loading = true">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Nombre -->
            <div class="col-span-1">
                <label for="name" class="block font-semibold theme-text text-base mb-2">
                    Nombre completo
                </label>
                <input id="name" name="name" type="text" x-model="currentName" required autocomplete="name"
                    class="block w-full px-4 py-2.5 rounded-lg
                           bg-[var(--bg)] theme-text
                           border theme-bd
                           placeholder:text-[color:var(--muted)]
                           focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]
                           focus:outline-none transition-colors"
                    placeholder="Santiago Rueda Quintero" />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-span-1">
                <label for="email" class="block font-semibold theme-text text-base mb-2">
                    Correo institucional
                </label>
                <input id="email" name="email" type="email" x-model="currentEmail" required
                    autocomplete="username"
                    class="block w-full px-4 py-2.5 rounded-lg
                           bg-[var(--bg)] theme-text
                           border theme-bd
                           placeholder:text-[color:var(--muted)]
                           focus:ring-2 focus:ring-[var(--accent)] focus:border-[var(--accent)]
                           focus:outline-none transition-colors"
                    placeholder="correo@institucion.edu" />
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-3 p-3 rounded-lg verification-warning-bg verification-warning-border">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 verification-warning-icon mt-0.5 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm verification-warning-text">
                                    Tu dirección de correo no ha sido verificada.
                                </p>
                                <button type="button" form="send-verification" onclick="this.form.submit()"
                                    class="mt-2 text-sm font-medium verification-warning-link hover:underline transition-all">
                                    Reenviar enlace de verificación
                                </button>
                            </div>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium success-text flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Enviamos un nuevo enlace de verificación.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit" :disabled="!hasChanges || loading"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg
                       font-semibold bg-[var(--accent)] text-white
                       hover:bg-[var(--primary)] hover:shadow-lg
                       focus:outline-none focus:ring-2 focus:ring-[var(--accent)]
                       transition-all duration-200
                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-none
                       min-w-[180px]">
                <svg x-show="loading" class="animate-spin h-5 w-5" style="display: none;" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span x-show="!loading">Guardar cambios</span>
                <span x-show="loading" style="display: none;">Guardando...</span>
            </button>

            <span x-show="!hasChanges && !loading" class="text-sm text-[color:var(--muted)]">
                No hay cambios pendientes
            </span>

            @if (session('status') === 'profile-updated')
                <span class="text-sm success-text font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Perfil actualizado correctamente
                </span>
            @endif
        </div>
    </form>
</section>

@push('scripts')
    <script>
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
