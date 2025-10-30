<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/FESC.JPG') }}');">

        <!-- Overlay institucional -->
        <div class="absolute inset-0 bg-[#1D1616]/70"></div>

        <!-- Contenedor principal -->
        <div
            class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-[#D84040]">

            <!-- Título -->
            <div class="text-center mb-6">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/fesc-30.png') }}" alt="FESC"
                        class="h-20 mx-auto mb-3 hover:scale-105 transition-transform">
                </a>
                <h2 class="text-2xl font-bold text-[#8E1616]">Recuperación de Contraseña</h2>
                <p class="text-sm text-gray-700 mt-1">Ingrese su correo para recuperar su contraseña</p>
            </div>

            <!-- Notificación de sesión -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Correo -->
                <div class="flex flex-col">
                    <label for="email" class="text-[#1D1616] font-semibold mb-1">Correo institucional</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800
                            focus:border-[#D84040] focus:ring focus:ring-[#D84040]/40 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Botón de enviar enlace -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 rounded-lg font-semibold text-white bg-[#8E1616]
                            hover:bg-[#D84040] transition duration-200 shadow-md">
                        ENVIAR ENLACE DE RESTABLECIMIENTO
                    </button>
                </div>

                <!-- Link a login -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-[#D84040] underline">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
