<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título y Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/ICONFESC.png?v=2') }}">
    <link rel="shortcut icon" href="{{ asset('images/ICONFESC.png?v=2') }}" type="image/png">
    <title>{{ config('app.name', 'SystemPOA') }}</title>

    <!-- Tipografías -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script>
        (function() {
            const saved = localStorage.getItem('theme') || 'light';
            document.documentElement.dataset.theme = saved;
            document.documentElement.classList.toggle('dark', saved === 'dark');
        })();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[var(--bg)]" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex flex-col">
        <div class="flex flex-1">
            <!-- Sidebar fijo en escritorio / off-canvas en móvil -->
            @include('layouts.navigation')

            <!-- Overlay móvil -->
            <div class="fixed inset-0 bg-black/40 z-30 lg:hidden" x-show="sidebarOpen" x-transition.opacity
                @click="sidebarOpen=false" style="display: none;"></div>

            <!-- Contenido -->
            <div class="flex-1 min-w-0 w-full lg:ml-64 flex flex-col">
                <!-- Topbar móvil -->
                <div class="lg:hidden sticky top-0 z-20 bg-[var(--card)] border-b border-[var(--border)]">
                    <div class="h-14 px-4 flex items-center justify-between">
                        <button @click="sidebarOpen = true"
                            class="p-2 rounded-md text-[var(--text)] hover:text-[var(--accent)] hover:bg-[var(--border)]/20 transition-colors"
                            aria-label="Abrir menú">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="text-sm text-[var(--text)] truncate">
                            SystemPOA
                        </div>
                        <div class="w-10"></div>
                    </div>
                </div>

                @if (isset($header))
                    <header class="bg-[var(--card)] border-b border-[var(--border)]">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                @include('layouts.footer')
            </div>
        </div>
    </div>

    <!-- Componente de notificaciones -->
    <x-notify />

    <!-- Flowbite (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    <!-- Sistema de notificaciones global -->
    <script>
        // Función global para mostrar notificaciones
        window.showNotification = function(message, type = 'info') {
            const notify = document.getElementById('notify');
            const notifyMessage = document.getElementById('notify-message');
            const notifyIcon = document.getElementById('notify-icon');
            const notifyCard = document.getElementById('notify-card');
            const notifyIconWrap = document.getElementById('notify-icon-wrap');

            if (!notify || !notifyMessage) return;

            // Configurar colores e iconos según el tipo
            const configs = {
                success: {
                    border: 'border-green-500',
                    iconBg: 'bg-green-100 dark:bg-green-900/30',
                    iconColor: 'text-green-600 dark:text-green-400',
                    icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />`
                },
                error: {
                    border: 'border-red-500',
                    iconBg: 'bg-red-100 dark:bg-red-900/30',
                    iconColor: 'text-red-600 dark:text-red-400',
                    icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`
                },
                warning: {
                    border: 'border-yellow-500',
                    iconBg: 'bg-yellow-100 dark:bg-yellow-900/30',
                    iconColor: 'text-yellow-600 dark:text-yellow-400',
                    icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-7.4 12.84A2 2 0 004.53 20h14.94a2 2 0 001.74-3.3L13.8 3.86a2 2 0 00-3.5 0z" />`
                },
                info: {
                    border: 'border-blue-500',
                    iconBg: 'bg-blue-100 dark:bg-blue-900/30',
                    iconColor: 'text-blue-600 dark:text-blue-400',
                    icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />`
                }
            };

            const config = configs[type] || configs.info;

            // Limpiar clases anteriores
            notifyCard.className = notifyCard.className.replace(/border-l-\w+-\d+/g, '');
            notifyIconWrap.className = notifyIconWrap.className.replace(/bg-\w+-\d+\/?\d*/g, '');
            notifyIcon.className = notifyIcon.className.replace(/text-\w+-\d+/g, '');

            // Aplicar nuevas clases
            notifyCard.classList.add(config.border);
            notifyIconWrap.className = `inline-flex items-center justify-center w-9 h-9 rounded-full ${config.iconBg}`;
            notifyIcon.className = `w-10 h-10 ${config.iconColor}`;

            // Cambiar el ícono
            notifyIcon.innerHTML = config.icon;

            // Mostrar mensaje
            notifyMessage.textContent = message;
            notify.classList.remove('hidden', '-translate-y-2', 'opacity-0');

            // Auto-cerrar después de 5 segundos
            setTimeout(() => {
                notify.classList.add('-translate-y-2', 'opacity-0');
                setTimeout(() => notify.classList.add('hidden'), 300);
            }, 5000);
        };

        // Cerrar al hacer clic en el botón X
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('notify-close')?.addEventListener('click', () => {
                const notify = document.getElementById('notify');
                notify.classList.add('-translate-y-2', 'opacity-0');
                setTimeout(() => notify.classList.add('hidden'), 300);
            });
        });
    </script>

    {{-- Notificación desde sesión --}}
    @if (session('notify'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const data = @json(session('notify'));
                showNotification(data.message ?? 'Operación realizada', data.type ?? 'info');
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
