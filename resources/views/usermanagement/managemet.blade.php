{{-- resources/views/usermanagement/management.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-2xl text-[var(--text)] leading-tight">
                    Control de Usuarios
                </h2>
                <p class="mt-1 text-sm text-[var(--text-muted)]">
                    Gestiona solicitudes de registro y permisos de usuarios activos
                </p>
            </div>
            <div class="flex gap-2">
                <span
                    class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-600 dark:text-yellow-400">
                    {{ $pendingUsers->count() }} Pendientes
                </span>
                <span
                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-600 dark:text-green-400">
                    {{ $activeUsers->count() }} Activos
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10 bg-[var(--bg)] min-h-screen">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">

                <!-- Solicitudes Pendientes -->
                <div
                    class="group relative overflow-hidden rounded-xl border border-[var(--border)]
                            bg-[var(--card)] shadow-sm hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-yellow-500/10 rounded-full blur-3xl -mr-20 -mt-20
                                group-hover:bg-yellow-500/15 transition-colors duration-500">
                    </div>

                    <div class="relative p-6 sm:p-8">
                        @include('usermanagement.partials.pending-requests', [
                            'pendingUsers' => $pendingUsers,
                        ])
                    </div>
                </div>

                <!-- Usuarios Activos -->
                <div
                    class="group relative overflow-hidden rounded-xl border border-[var(--border)]
                            bg-[var(--card)] shadow-sm hover:shadow-lg transition-all duration-300">
                    <div
                        class="absolute bottom-0 left-0 w-40 h-40 bg-green-500/10 rounded-full blur-3xl -ml-20 -mb-20
                                group-hover:bg-green-500/15 transition-colors duration-500">
                    </div>

                    <div class="relative p-6 sm:p-8">
                        @include('usermanagement.partials.active-users', ['activeUsers' => $activeUsers])
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modales -->
    @include('usermanagement.partials.modals.approve-user', ['roles' => $roles])
    @include('usermanagement.partials.modals.reject-user')
    @include('usermanagement.partials.modals.edit-role', ['roles' => $roles])
    @include('usermanagement.partials.modals.delete-user')

    <!-- Scripts -->
    @push('scripts')
        @include('usermanagement.partials.scripts')
    @endpush
</x-app-layout>
