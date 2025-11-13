{{-- resources/views/usermanagement/partials/active-users.blade.php --}}
<div class="space-y-4">
    <!-- Header con Búsqueda y Filtros -->
    <div class="flex flex-col gap-4 pb-4 border-b border-[var(--border)]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
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
                <div>
                    <h3 class="text-lg font-bold text-[var(--text)]">
                        Usuarios Activos
                    </h3>
                    <p class="text-sm text-[var(--text-muted)]">
                        {{ $activeUsers->total() }} usuarios registrados
                    </p>
                </div>
            </div>
        </div>

        <!-- Buscador y Filtros -->
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach (request()->except('active_search', 'active_role', 'active_page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <!-- Buscador -->
            <div class="relative">
                <input type="text" name="active_search" value="{{ request('active_search') }}"
                    placeholder="Buscar por nombre, email o área..."
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
            <div class="relative">
                <select name="active_role"
                    class="w-full px-4 py-2 rounded-lg border border-[var(--border)]
                               bg-[var(--card)] text-[var(--text)] text-sm
                               focus:ring-2 focus:ring-green-500 focus:border-transparent
                               transition-all appearance-none">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ request('active_role') === $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                <svg class="w-4 h-4 absolute right-3 top-3 text-[var(--text-muted)] pointer-events-none" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Botones -->
            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg
                               bg-green-600 hover:bg-green-700 text-white text-sm font-medium
                               transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtrar
                </button>

                @if (request('active_search') || request('active_role'))
                    <a href="{{ route('user-management.index', array_filter(request()->except('active_search', 'active_role', 'active_page'))) }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-lg
                              border border-[var(--border)] text-[var(--text)] text-sm font-medium
                              hover:bg-[var(--border)]/5 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Content -->
    <div id="active-users-container">
        @if ($activeUsers->count() > 0)
            <!-- Tabla de usuarios activos -->
            <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
                <table class="w-full" id="active-users-table">
                    <thead>
                        <tr class="bg-[var(--border)]/5 border-b border-[var(--border)]">
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-[var(--text)] uppercase tracking-wider">
                                Usuario
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-[var(--text)] uppercase tracking-wider hidden md:table-cell">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-[var(--text)] uppercase tracking-wider hidden lg:table-cell">
                                Rol / Área
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-semibold text-[var(--text)] uppercase tracking-wider">
                                Estado
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-semibold text-[var(--text)] uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($activeUsers as $user)
                            <tr class="hover:bg-[var(--border)]/5 transition-colors">
                                <!-- Usuario -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                                    flex items-center justify-center text-white font-bold text-sm shrink-0">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-[var(--text)]">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-sm text-[var(--text-muted)] md:hidden">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email (oculto en móvil) -->
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-sm text-[var(--text)]">{{ $user->email }}</div>
                                </td>

                                <!-- Rol / Área (oculto en tablet) -->
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                     bg-blue-500/20 text-blue-700 dark:text-blue-300 border border-blue-500/30 w-fit">
                                            {{ $user->role_name ?? 'Sin rol' }}
                                        </span>
                                        @if ($user->area)
                                            <span class="text-xs text-[var(--text-muted)]">{{ $user->area }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-green-500/20 text-green-700 dark:text-green-300
                                                 border border-green-500/30">
                                        Activo
                                    </span>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                            onclick="openEditRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->role_name ?? '') }}', '{{ addslashes($user->area ?? '') }}', {{ $user->is_active ? 'true' : 'false' }})"
                                            class="inline-flex items-center justify-center p-1.5 rounded-lg
                                                    bg-blue-500/10 text-blue-600 dark:text-blue-400
                                                    hover:bg-blue-500/20 transition-all
                                                    border border-blue-500/20 hover:border-blue-500/40"
                                            title="Editar usuario">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button type="button"
                                            onclick="deleteUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                            class="inline-flex items-center justify-center p-1.5 rounded-lg
                                                   bg-red-500/10 text-red-600 dark:text-red-400
                                                   hover:bg-red-500/20 transition-all
                                                   border border-red-500/20 hover:border-red-500/40"
                                            title="Eliminar usuario">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if ($activeUsers->hasPages())
                <div class="mt-4 pt-4 border-t border-[var(--border)]">
                    <x-pagination :paginator="$activeUsers" pageName="active_page" />
                </div>
            @endif
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-500/10 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-[var(--text)] mb-1">
                    @if (request('active_search') || request('active_role'))
                        No se encontraron resultados
                    @else
                        No hay usuarios activos
                    @endif
                </h4>
                <p class="text-sm text-[var(--text-muted)] mb-4">
                    @if (request('active_search') || request('active_role'))
                        Intenta ajustar los filtros de búsqueda
                    @else
                        Los usuarios aparecerán aquí una vez sean aprobados
                    @endif
                </p>
                @if (request('active_search') || request('active_role'))
                    <a href="{{ route('user-management.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                              bg-[var(--primary)] text-white font-medium
                              hover:bg-[var(--primary)]/90 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpiar filtros
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
