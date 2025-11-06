<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SystemPOA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div>
        {{ $slot }}
    </div>

    {{-- notificación --}}
    <x-notify />
    @if (session('notify'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const data = @json(session('notify'));
                window.notify?.show(data.message ?? 'Operación realizada', data.type ?? 'info');
            });
        </script>
    @endif
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.notify?.show(@json(session('status')), 'success');
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const firstError = @json($errors->first());
                if (firstError) window.notify?.show(firstError, 'error');
            });
        </script>
    @endif
</body>

</html>
