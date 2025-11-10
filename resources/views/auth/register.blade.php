<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/FESC.JPG') }}');">

        <!-- Overlay institucional -->
        <div class="absolute inset-0 bg-[#1D1616]/70"></div>

        <!-- Contenedor principal -->
        <div
            class="relative z-10 w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-[#D84040]">

            <!-- Logo y título -->
            <div class="text-center mb-6">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/fesc-30.png') }}" alt="FESC"
                        class="h-20 mx-auto mb-3 hover:scale-105 transition-transform">
                </a>
                <h2 class="text-2xl font-bold text-[#8E1616]">Pre-Registro FESC</h2>
                <p class="text-sm text-gray-700 mt-1">Complete sus datos para solicitar acceso</p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <!-- Nombre -->
                <div class="flex flex-col">
                    <label for="name" class="text-[#1D1616] font-semibold mb-1">Nombre completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800
                            focus:border-[#D84040] focus:ring focus:ring-[#D84040]/40 transition duration-200">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Correo -->
                <div class="flex flex-col">
                    <label for="email" class="text-[#1D1616] font-semibold mb-1">Correo institucional</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800
                            focus:border-[#D84040] focus:ring focus:ring-[#D84040]/40 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="flex flex-col">
                    <label for="password" class="text-[#1D1616] font-semibold mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800
                            focus:border-[#D84040] focus:ring focus:ring-[#D84040]/40 transition duration-200">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar contraseña -->
                <div class="flex flex-col">
                    <label for="password_confirmation" class="text-[#1D1616] font-semibold mb-1">Confirmar
                        contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-800
                            focus:border-[#D84040] focus:ring focus:ring-[#D84040]/40 transition duration-200">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botón -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 rounded-lg font-semibold text-white bg-[#8E1616]
                            hover:bg-[#D84040] transition duration-200 shadow-md">
                        ENVIAR PREREGISTRO
                    </button>
                </div>

                <!-- Link a login -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-[#D84040] underline">
                        ¿Ya tiene cuenta? Inicie sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
