{{-- resources/views/usermanagement/partials/modals/approve-user.blade.php --}}
<x-modal name="approve-user-modal" :show="false" maxWidth="2xl">
    <div class="p-6 bg-[var(--card)]">
        <!-- Header -->
        <div class="flex items-start gap-4 mb-6">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600
                        flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-[var(--text)] mb-1">
                    Aprobar Usuario
                </h3>
                <p class="text-sm text-[var(--text-muted)]">
                    Asigna un rol y área al nuevo usuario
                </p>
            </div>
            <button type="button"
                @click="show = false"
                class="text-[var(--text-muted)] hover:text-[var(--text)] transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- User Info Card -->
        <div id="user-info" class="mb-6 p-4 rounded-lg bg-[var(--border)]/10 border border-[var(--border)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                            flex items-center justify-center text-white font-bold"
                    id="approve-user-avatar">
                    ?
                </div>
                <div>
                    <p class="font-semibold text-[var(--text)]" id="approve-user-name">Nombre del Usuario</p>
                    <p class="text-sm text-[var(--text-muted)]" id="approve-user-email">email@ejemplo.com</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="approve-form" class="space-y-5">
            @csrf
            <input type="hidden" id="approve-user-id" name="user_id">

            <!-- Rol -->
            <div>
                <label for="approve-role" class="block text-sm font-semibold text-[var(--text)] mb-2">
                    Rol <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="role" id="approve-role" required
                        class="w-full px-4 py-2.5 rounded-lg border border-[var(--border)]
                               bg-[var(--card)] text-[var(--text)]
                               focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                               transition-all appearance-none cursor-pointer">
                        <option value="">Seleccionar rol...</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-5 h-5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <p class="mt-1.5 text-xs text-[var(--text-muted)]">
                    Define el nivel de acceso del usuario
                </p>
            </div>

            <!-- Área -->
            <div>
                <label for="approve-area" class="block text-sm font-semibold text-[var(--text)] mb-2">
                    Área <span class="text-[var(--text-muted)] font-normal">(opcional)</span>
                </label>
                <input type="text" name="area" id="approve-area"
                    class="w-full px-4 py-2.5 rounded-lg border border-[var(--border)]
                           bg-[var(--card)] text-[var(--text)]
                           focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                           placeholder:text-[var(--text-muted)] transition-all"
                    placeholder="Ej: Recursos Humanos, IT, Ventas...">
                <p class="mt-1.5 text-xs text-[var(--text-muted)]">
                    Departamento o área de trabajo del usuario
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 justify-end pt-4 border-t border-[var(--border)]">
                <button type="button"
                    @click="show = false"
                    class="px-5 py-2.5 rounded-lg border border-[var(--border)]
                           text-[var(--text)] bg-[var(--card)]
                           hover:bg-[var(--border)]/10 transition-all font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600
                           text-white font-semibold hover:shadow-lg hover:scale-[1.02]
                           active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Aprobar y Asignar</span>
                </button>
            </div>
        </form>
    </div>
</x-modal>
