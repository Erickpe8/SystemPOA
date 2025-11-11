{{-- resources/views/usermanagement/partials/active-users.blade.php --}}
<div class="space-y-4">
    <!-- Header con Búsqueda y Filtros -->
    <div class="flex flex-col gap-4 pb-4 border-b border-[var(--border)]">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500/20 to-emerald-600/10
                        flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-[var(--text)]">
                    Usuarios Activos
                </h3>
                <p class="text-sm text-[var(--text-muted)]">
                    <span id="active-count">{{ $activeUsers->count() }}</span> usuarios registrados
                </p>
            </div>
        </div>

        <!-- Barra de Búsqueda y Filtros -->
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Buscador -->
            <div class="relative flex-1">
                <input type="text" id="search-active" placeholder="Buscar por nombre, email o área..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-[var(--border)]
                           bg-[var(--card)] text-[var(--text)] text-sm
                           focus:ring-2 focus:ring-green-500 focus:border-transparent
                           placeholder:text-[var(--text-muted)] transition-all">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filtro por Rol -->
            <div class="relative w-full sm:w-48">
                <select id="filter-role"
                    class="w-full pl-10 pr-10 py-2 rounded-lg border border-[var(--border)]
                           bg-[var(--card)] text-[var(--text)] text-sm
                           focus:ring-2 focus:ring-green-500 focus:border-transparent
                           appearance-none cursor-pointer transition-all">
                    <option value="">Todos los roles</option>
                    @foreach ($activeUsers->pluck('roles')->flatten()->unique('name') as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                <svg class="w-4 h-4 absolute left-3 top-3 text-[var(--text-muted)] pointer-events-none" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <svg class="w-4 h-4 absolute right-3 top-3 text-[var(--text-muted)] pointer-events-none" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Tabla responsive -->
    <div class="overflow-x-auto -mx-4 sm:mx-0">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden border border-[var(--border)] rounded-lg">
                <table class="min-w-full divide-y divide-[var(--border)]">
                    <thead class="bg-[var(--border)]/10">
                        <tr>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-[var(--text-secondary)]">
                                Usuario
                            </th>
                            <th scope="col"
                                class="hidden md:table-cell px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-[var(--text-secondary)]">
                                Email
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-[var(--text-secondary)]">
                                Rol
                            </th>
                            <th scope="col"
                                class="hidden lg:table-cell px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-[var(--text-secondary)]">
                                Área
                            </th>
                            <th scope="col"
                                class="px-4 sm:px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-[var(--text-secondary)]">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody id="active-users-tbody" class="bg-[var(--card)] divide-y divide-[var(--border)]">
                        @foreach ($activeUsers as $user)
                            <tr class="active-user-row hover:bg-[var(--border)]/5 transition-colors duration-150"
                                data-user-id="{{ $user->id }}" data-user-name="{{ strtolower($user->name) }}"
                                data-user-email="{{ strtolower($user->email) }}"
                                data-user-role="{{ $user->roles->first()?->name ?? '' }}"
                                data-user-area="{{ strtolower($user->area ?? '') }}">
                                <!-- Usuario -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                                flex items-center justify-center text-white font-bold shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-medium text-[var(--text)] truncate">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-sm text-[var(--text-muted)] truncate md:hidden">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-[var(--text-secondary)]">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                <!-- Rol -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @if ($user->roles->isNotEmpty())
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-[var(--primary)]/10 text-[var(--primary)] border border-[var(--primary)]/20">
                                            {{ $user->roles->pluck('name')->implode(', ') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-500/20">
                                            Sin rol
                                        </span>
                                    @endif
                                </td>

                                <!-- Área -->
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-[var(--text-secondary)]">
                                        {{ $user->area ?? 'N/A' }}
                                    </div>
                                </td>

                                <!-- Acciones -->
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            onclick="openEditRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->roles->first()?->name }}', '{{ addslashes($user->area ?? '') }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                                   bg-blue-500/10 text-blue-600 dark:text-blue-400
                                                   hover:bg-blue-500/20 text-xs font-medium transition-all
                                                   border border-blue-500/20 hover:border-blue-500/40"
                                            title="Cambiar rol">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="hidden sm:inline">Editar</span>
                                        </button>

                                        @if ($user->id !== auth()->id())
                                            <button
                                                onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                                       bg-red-500/10 text-red-600 dark:text-red-400
                                                       hover:bg-red-500/20 text-xs font-medium transition-all
                                                       border border-red-500/20 hover:border-red-500/40"
                                                title="Eliminar usuario">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span class="hidden sm:inline">Eliminar</span>
                                            </button>
                                        @else
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                                        bg-gray-500/10 text-gray-600 dark:text-gray-400
                                                        text-xs font-medium cursor-not-allowed opacity-50"
                                                title="No puedes eliminarte a ti mismo">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                <span class="hidden sm:inline">Tú</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Mensaje "No encontrado" -->
                <div id="no-results-active" class="hidden text-center py-12">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-500/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-[var(--text)] mb-1">
                        No se encontraron resultados
                    </h4>
                    <p class="text-sm text-[var(--text-muted)]">
                        Intenta con otros términos de búsqueda o filtros
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
