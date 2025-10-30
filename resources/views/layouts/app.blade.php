<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título y Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/ICONFESC.png?v=2') }}">
    <link rel="shortcut icon" href="{{ asset('images/ICONFESC.png?v=2') }}" type="image/png">


    <!-- Tipografías -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar fijo en escritorio / off-canvas en móvil -->
        @include('layouts.navigation')

        <!-- Overlay móvil -->
        <div class="fixed inset-0 bg-black/40 z-30 lg:hidden" x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen=false"></div>

        <!-- Contenido -->
        <div class="flex-1 min-w-0 w-full lg:ml-64">
            <!-- Topbar móvil -->
            <div class="lg:hidden sticky top-0 z-20 bg-white border-b border-gray-200">
                <div class="h-14 px-4 flex items-center justify-between">
                    <button @click="sidebarOpen = true" class="p-2 rounded-md text-gray-600 hover:bg-gray-100" aria-label="Abrir menú">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="text-sm text-gray-600 truncate">{{ config('app.name', 'Laravel') }}</div>
                    <div class="w-6"></div>
                </div>
            </div>

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
        <!-- Flowbite -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
</html>
