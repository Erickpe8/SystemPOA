{{-- resources/views/usermanagement/partials/pending-requests.blade.php --}}
<div class="space-y-4">
    <!-- Header con Búsqueda -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-[var(--border)]">
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
                    <span id="pending-count">{{ $pendingUsers->count() }}</span> solicitudes por revisar
                </p>
            </div>
        </div>

        <!-- Buscador -->
        <div class="relative w-full sm:w-64">
            <input type="text" id="search-pending" placeholder="Buscar por nombre o email..."
                class="w-full pl-10 pr-4 py-2 rounded-lg border border-[var(--border)]
                       bg-[var(--card)] text-[var(--text)] text-sm
                       focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                       placeholder:text-[var(--text-muted)] transition-all">
            <svg class="w-5 h-5 absolute left-3 top-2.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Content -->
    <div id="pending-users-container">
        @if ($pendingUsers->isEmpty())
            <!-- Estado vacío -->
            <div class="text-center py-12" id="empty-pending-state">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-500/10 flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-[var(--text)] mb-1">
                    No hay solicitudes pendientes
                </h4>
                <p class="text-sm text-[var(--text-muted)]">
                    Todas las solicitudes han sido procesadas
                </p>
            </div>
        @else
            <!-- Grid de usuarios pendientes -->
            <div id="pending-users-grid" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($pendingUsers as $user)
                    <div class="pending-user-card" data-user-id="{{ $user->id }}"
                        data-user-name="{{ strtolower($user->name) }}" data-user-email="{{ strtolower($user->email) }}">
                        <div
                            class="group relative overflow-hidden p-4 rounded-lg border border-[var(--border)]
                                bg-gradient-to-br from-[var(--border)]/5 to-transparent
                                hover:shadow-md hover:border-yellow-500/30 transition-all duration-300">

                            <!-- Badge de estado -->
                            <div class="absolute top-2 right-2">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold
                                         bg-yellow-500/20 text-yellow-700 dark:text-yellow-300
                                         border border-yellow-500/30">
                                    Pendiente
                                </span>
                            </div>

                            <!-- Avatar y Info -->
                            <div class="flex items-start gap-3 mb-4 pr-20">
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                                        flex items-center justify-center text-white font-bold text-lg shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-[var(--text)] truncate">
                                        {{ $user->name }}
                                    </h4>
                                    <p class="text-sm text-[var(--text-muted)] truncate">
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>

                            <!-- Fecha de registro -->
                            <div class="flex items-center gap-2 mb-4 text-xs text-[var(--text-muted)]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $user->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Acciones -->
                            <div class="flex gap-2">
                                <button
                                    onclick="openApprovalModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')"
                                    class="flex-1 px-3 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600
                                           text-white text-sm font-medium hover:shadow-lg hover:scale-[1.02]
                                           active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Aprobar</span>
                                </button>
                                <button
                                    onclick="openRejectModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')"
                                    class="px-3 py-2 rounded-lg bg-red-500/10 text-red-600 dark:text-red-400
                                           hover:bg-red-500/20 text-sm font-medium transition-all
                                           border border-red-500/20 hover:border-red-500/40"
                                    title="Rechazar solicitud">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mensaje de "no encontrado" (oculto por defecto) -->
            <div id="no-results-pending" class="hidden text-center py-12">
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
                    Intenta con otros términos de búsqueda
                </p>
            </div>
        @endif
    </div>
</div>
