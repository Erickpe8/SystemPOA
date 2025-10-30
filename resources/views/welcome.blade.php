<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SystemPOA - FESC</title>

    <!-- Tailwind y Flowbite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <style>
        body {
            background-image: url('{{ asset('images/FESC.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .overlay {
            background-color: rgba(29, 22, 22, 0.7);
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body class="antialiased font-sans text-gray-100">
    <!-- Capa difuminada sobre la imagen -->
    <div class="overlay min-h-screen flex flex-col justify-between">

        <!-- Header -->
        <header class="flex flex-wrap justify-between items-center px-4 sm:px-6 py-3 bg-[#1D1616]/70">
            <div class="flex items-center gap-3">
                <!-- Logo actualizado -->
                <img src="{{ asset('images/FESC-30.png') }}" alt="Logo FESC" class="h-10 sm:h-12 w-auto">
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#D84040] tracking-wide">SystemPOA</h1>
            </div>

            <!-- Navegación -->
            <nav class="flex flex-wrap gap-2 sm:gap-3 mt-3 sm:mt-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-3 sm:px-4 py-2 rounded-lg bg-[#D84040] hover:bg-[#8E1616] text-sm sm:text-base transition font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-3 sm:px-4 py-2 rounded-lg bg-[#D84040] hover:bg-[#8E1616] text-sm sm:text-base transition font-semibold">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-3 sm:px-4 py-2 rounded-lg border border-[#D84040] text-sm sm:text-base hover:bg-[#8E1616] hover:text-white transition font-semibold">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Contenido principal -->
        <main class="flex flex-col items-center justify-center flex-1 px-4 sm:px-6 py-8">
            <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-center">
                <!-- Carrusel a la izquierda -->
                <div id="auto-carousel"
                    class="relative w-full h-56 sm:h-64 md:h-72 overflow-hidden rounded-xl shadow-lg md:w-4/5 mx-auto">

                    <!-- Contenedor de las imágenes -->
                    <div class="relative w-full h-full">
                        <div
                            class="carousel-item absolute inset-0 opacity-100 transition-opacity duration-1000 ease-in-out">
                            <img src="{{ asset('images/1.png') }}"
                                class="w-full h-full object-cover object-center rounded-xl" alt="Imagen FESC 1">
                        </div>
                        <div
                            class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                            <img src="{{ asset('images/2.png') }}"
                                class="w-full h-full object-cover object-center rounded-xl" alt="Imagen FESC 2">
                        </div>
                        <div
                            class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                            <img src="{{ asset('images/3.png') }}"
                                class="w-full h-full object-cover object-center rounded-xl bg-[#1D1616]"
                                alt="Pilares Estratégicos">
                        </div>
                        <div
                            class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                            <img src="{{ asset('images/4.png') }}"
                                class="w-full h-full object-cover object-center rounded-xl" alt="Imagen FESC 4">
                        </div>
                        <div
                            class="carousel-item absolute inset-0 opacity-0 transition-opacity duration-1000 ease-in-out">
                            <img src="{{ asset('images/5.png') }}"
                                class="w-full h-full object-cover object-center rounded-xl" alt="Imagen FESC 5">
                        </div>
                    </div>
                </div>

                <!-- Modal de actualizaciones -->
                <div class="relative flex flex-col items-center justify-center text-center
                            bg-[#1D1616]/80 backdrop-blur-md rounded-xl shadow-lg border border-[#8E1616]/50
                            h-56 sm:h-64 md:h-72 md:w-4/5 mx-auto overflow-hidden px-4 sm:px-6 py-6 sm:py-8">

                    <!-- Contenido centrado -->
                    <div class="flex flex-col items-center justify-center space-y-5">
                        <!-- Título -->
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-[#D84040] mb-2">Actualizaciones</h3>
                            <p class="text-[#EEEEEE] text-sm sm:text-base leading-relaxed max-w-md mx-auto">
                                Mantente informado sobre las últimas mejoras del <strong>SystemPOA</strong> y consulta el historial de cambios que optimizan su desempeño, estabilidad y seguridad institucional.
                            </p>
                        </div>

                        <!-- Botón centrado -->
                        <a href="#"
                        class="inline-flex items-center justify-center gap-2 px-8 sm:px-10 py-3 sm:py-4 text-sm sm:text-base font-semibold rounded-lg
                                border border-[#D84040] text-[#EEEEEE] hover:bg-[#8E1616] hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ver más
                        </a>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-4 bg-[#1D1616]/70 text-[#EEEEEE] text-xs sm:text-sm">
            <p>&copy; {{ date('Y') }} Fundación de Estudios Superiores Comfanorte — FESC</p>
            <p class="mt-1">Desarrollado por la Unidad de Desarrollo</p>
        </footer>
    </div>

    <!-- Script de autoplay -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('#auto-carousel .carousel-item');
            let index = 0;
            const total = items.length;

            function showSlide(nextIndex) {
                items[index].classList.remove('opacity-100');
                items[index].classList.add('opacity-0');

                items[nextIndex].classList.remove('opacity-0');
                items[nextIndex].classList.add('opacity-100');

                index = nextIndex;
            }

            setInterval(() => {
                const nextIndex = (index + 1) % total;
                showSlide(nextIndex);
            }, 3000);
        });
    </script>
</body>

</html>
