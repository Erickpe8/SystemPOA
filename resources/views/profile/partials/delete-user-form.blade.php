<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-[var(--text)]">
            {{ __('Eliminar cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-[color:var(--text)]/70">
            {{ __('Una vez elimine su cuenta, todos sus recursos y datos se borrarán de forma permanente. Antes de continuar, descargue cualquier información que desee conservar.') }}
        </p>
    </header>

    {{-- Botón principal (peligro) --}}
    <x-danger-button
        class="bg-[var(--accent)] hover:bg-[var(--primary)] border border-[color:var(--border)]"
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Eliminar cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
              class="p-6 bg-[var(--card)] border border-[color:var(--border)] rounded-xl">
            @csrf
            @method('delete')

            <div class="flex items-start gap-3">
                {{-- Ícono alerta --}}
                <div class="shrink-0 mt-1 inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#8E1616]/30">
                    <svg class="w-6 h-6 text-[#D84040]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v4m0 4h.01M10.29 3.86l-7.4 12.84A2 2 0 004.53 20h14.94a2 2 0 001.74-3.3L13.8 3.86a2 2 0 00-3.5 0z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-[var(--text)]">
                        {{ __('¿Está seguro de que desea eliminar su cuenta?') }}
                    </h2>
                    <p class="mt-1 text-sm text-[color:var(--text)]/70">
                        {{ __('Una vez eliminada, todos sus recursos y datos se borrarán de forma permanente. Ingrese su contraseña para confirmar que desea eliminar su cuenta de manera definitiva.') }}
                    </p>
                </div>
            </div>

            {{-- Password --}}
            <div class="mt-6 max-w-md" x-data="{ show: false }">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        x-bind:type="show ? 'text' : 'password'"
                        class="mt-1 block w-full pr-12
                            bg-[var(--bg)] text-[var(--text)] border border-[color:var(--border)]
                            placeholder:text-[color:var(--text)]/50 focus:ring-2 focus:ring-[#D84040] focus:border-[#D84040]"
                        placeholder="{{ __('Contraseña') }}"
                        required
                    />

                    <button type="button"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-[color:var(--text)]/70 hover:text-[var(--text)]"
                            x-on:click="show = !show" x-bind:aria-pressed="show.toString()">
                        <svg x-show="!show" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" x-cloak class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.964 9.964 0 012.926-4.568M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1l11.8 11.8" />
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[#D84040]" />
            </div>

            {{-- Footer acciones --}}
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button
                    class="border border-[color:var(--border)] text-[var(--text)] hover:bg-[var(--primary)]/20"
                    x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button
                    class="ms-3 bg-[var(--accent)] hover:bg-[var(--primary)] border border-[color:var(--border)]">
                    {{ __('Eliminar cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
