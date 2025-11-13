{{-- resources/views/usermanagement/partials/modals/edit-role.blade.php --}}
<x-modal name="edit-role-modal" :show="false">
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-start gap-4 mb-6">
            <div
                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600
                        flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-[var(--text)] mb-1">
                    Gestionar Usuario
                </h3>
                <p class="text-sm text-[var(--text-muted)]">
                    Actualiza el rol, área y estado del usuario
                </p>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="mb-6 p-4 rounded-lg bg-[var(--border)]/10 border border-[var(--border)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                            flex items-center justify-center text-white font-bold"
                    id="edit-user-avatar">
                    ?
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-[var(--text)]" id="edit-user-name"></p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-[var(--text-muted)]">Rol actual:</span>
                        <span class="text-xs font-medium text-[var(--primary)]" id="edit-current-role"></span>
                    </div>
                </div>
                <!-- Estado Badge -->
                <div id="edit-user-status-badge"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="edit-role-form" class="space-y-5" onsubmit="submitEditRoleForm(event); return false;">
            @csrf
            <input type="hidden" id="edit-user-id" name="user_id">

            <!-- Estado del Usuario (Toggle) -->
            <div class="p-4 rounded-lg border-2 border-[var(--border)] bg-[var(--card)]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-purple-600/10
                                    flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <label for="edit-is-active" class="block text-sm font-semibold text-[var(--text)]">
                                Estado del Usuario
                            </label>
                            <p class="text-xs text-[var(--text-muted)] mt-0.5">
                                Activa o desactiva el acceso del usuario al sistema
                            </p>
                        </div>
                    </div>

                    <!-- Toggle Switch -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="edit-is-active" name="is_active" class="sr-only peer" checked>
                        <div
                            class="w-14 h-7 bg-gray-300 dark:bg-gray-600 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-6 after:w-6 after:transition-all
                                    peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-emerald-600
                                    transition-all duration-200">
                        </div>
                        <span class="ml-3 text-sm font-medium" id="edit-status-label">
                            <span class="text-green-600 dark:text-green-400">Activo</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Nuevo Rol -->
            <div>
                <label for="edit-role" class="block text-sm font-semibold text-[var(--text)] mb-2">
                    Nuevo Rol <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="role" id="edit-role" required
                        class="w-full px-4 py-2.5 rounded-lg border border-[var(--border)]
                               bg-[var(--card)] text-[var(--text)]
                               focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                               transition-all appearance-none cursor-pointer">
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
                    Selecciona el nuevo rol para el usuario
                </p>
            </div>

            <!-- Área -->
            <div>
                <label for="edit-area" class="block text-sm font-semibold text-[var(--text)] mb-2">
                    Área <span class="text-[var(--text-muted)] font-normal">(opcional)</span>
                </label>
                <input type="text" name="area" id="edit-area"
                    class="w-full px-4 py-2.5 rounded-lg border border-[var(--border)]
                           bg-[var(--card)] text-[var(--text)]
                           focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                           placeholder:text-[var(--text-muted)] transition-all"
                    placeholder="Ej: Recursos Humanos, IT, Ventas...">
                <p class="mt-1.5 text-xs text-[var(--text-muted)]">
                    Actualiza el departamento o área de trabajo
                </p>
            </div>

            <!-- Warning Info -->
            <div class="flex items-start gap-3 p-3 rounded-lg bg-blue-500/10 border border-blue-500/20">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0 mt-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                    Los cambios afectarán inmediatamente los permisos y accesos del usuario.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 justify-end pt-4 border-t border-[var(--border)]">
                <button type="button" onclick="closeModal('edit-role-modal')"
                    class="px-5 py-2.5 rounded-lg border border-[var(--border)]
                           text-[var(--text)] bg-[var(--card)]
                           hover:bg-[var(--border)]/10 transition-all font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-[var(--primary)] to-[var(--accent)]
                           text-white font-semibold hover:shadow-lg hover:scale-[1.02]
                           active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    // Toggle del estado activo con actualización visual
    document.addEventListener('DOMContentLoaded', function() {
        const toggleCheckbox = document.getElementById('edit-is-active');
        const statusLabel = document.getElementById('edit-status-label');

        if (toggleCheckbox && statusLabel) {
            toggleCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    statusLabel.innerHTML =
                        '<span class="text-green-600 dark:text-green-400 font-semibold">Activo</span>';
                } else {
                    statusLabel.innerHTML =
                        '<span class="text-red-600 dark:text-red-400 font-semibold">Inactivo</span>';
                }
            });
        }
    });
</script>
