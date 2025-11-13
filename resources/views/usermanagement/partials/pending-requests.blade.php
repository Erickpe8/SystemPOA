{{-- resources/views/usermanagement/partials/pending-requests.blade.php --}}
<div class="space-y-4">
    <!-- Header con Búsqueda y Filtros -->
    <div class="flex flex-col gap-4 pb-4 border-b border-[var(--border)]">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500/20 to-yellow-600/10
                            flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[var(--text)]">
                        Solicitudes Pendientes
                    </h3>
                    <p class="text-sm text-[var(--text-muted)]">
                        {{ $pendingUsers->total() }} solicitudes por revisar
                    </p>
                </div>
            </div>

            <!-- Buscador -->
            <form method="GET" class="relative w-full sm:w-64">
                @foreach (request()->except('pending_search', 'pending_page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="text" name="pending_search" value="{{ request('pending_search') }}"
                    placeholder="Buscar por nombre o email..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-[var(--border)]
                              bg-[var(--card)] text-[var(--text)] text-sm
                              focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                              placeholder:text-[var(--text-muted)] transition-all"
                    onchange="this.form.submit()">
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
        </div>

        <!-- Botón limpiar filtros (si hay búsqueda activa) -->
        @if (request('pending_search'))
            <div>
                <a href="{{ route('user-management.index', array_filter(request()->except('pending_search', 'pending_page'))) }}"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm
                          border border-[var(--border)] text-[var(--text)]
                          hover:bg-[var(--border)]/5 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Limpiar búsqueda
                </a>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div id="pending-users-container">
        @if ($pendingUsers->count() > 0)
            <!-- Tabla de usuarios pendientes -->
            <div class="overflow-x-auto rounded-lg border border-[var(--border)]">
                <table class="w-full" id="pending-users-table">
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
                                Fecha de Solicitud
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
                        @foreach ($pendingUsers as $user)
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

                                <!-- Fecha (oculto en tablet) -->
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <div class="flex items-center gap-2 text-sm text-[var(--text-muted)]">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $user->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-xs text-[var(--text-muted)] mt-0.5">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-yellow-500/20 text-yellow-700 dark:text-yellow-300
                                                 border border-yellow-500/30">
                                        Pendiente
                                    </span>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                            onclick="openApprovalModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                                   bg-gradient-to-r from-green-500 to-emerald-600
                                                   text-white text-sm font-medium
                                                   hover:shadow-lg hover:scale-105 active:scale-95
                                                   transition-all duration-200"
                                            title="Aprobar usuario">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="hidden sm:inline">Aprobar</span>
                                        </button>
                                        <button type="button"
                                            onclick="openRejectModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                            class="inline-flex items-center justify-center p-1.5 rounded-lg
                                                   bg-red-500/10 text-red-600 dark:text-red-400
                                                   hover:bg-red-500/20 transition-all
                                                   border border-red-500/20 hover:border-red-500/40"
                                            title="Rechazar solicitud">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
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
            @if ($pendingUsers->hasPages())
                <div class="mt-4 pt-4 border-t border-[var(--border)]">
                    <x-pagination :paginator="$pendingUsers" pageName="pending_page" />
                </div>
            @endif
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-500/10 flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-[var(--text)] mb-1">
                    @if (request('pending_search'))
                        No se encontraron resultados
                    @else
                        No hay solicitudes pendientes
                    @endif
                </h4>
                <p class="text-sm text-[var(--text-muted)] mb-4">
                    @if (request('pending_search'))
                        Intenta con otros términos de búsqueda
                    @else
                        Todas las solicitudes han sido procesadas
                    @endif
                </p>
                @if (request('pending_search'))
                    <a href="{{ route('user-management.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                              bg-[var(--primary)] text-white font-medium
                              hover:bg-[var(--primary)]/90 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpiar búsqueda
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
