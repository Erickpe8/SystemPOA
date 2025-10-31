<x-app-layout>
    {{-- Header con toggle de tema --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[var(--text)] leading-tight">
                {{ __('Profile') }}
            </h2>

            {{-- Toggle Dark/Light (sin nuevos archivos) --}}
            <button id="themeToggleProfile"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-[color:var(--border)]
                       hover:bg-[var(--accent)]/20 transition text-sm text-[var(--text)]"
                aria-pressed="false" aria-label="Cambiar tema">
                <svg id="iconSunProfile"  class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v2m0 12v2m8-8h-2M6 12H4m12.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0l-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg id="iconMoonProfile" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
                <span class="font-semibold">Tema</span>
            </button>
        </div>
    </x-slot>

    {{-- Exterior con paleta institucional (sin tocar parciales) --}}
    <div class="py-12 bg-[var(--bg)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    {{-- Script del toggle (UI + localStorage, sin recargar) --}}
    <script>
        (function(){
            const KEY = 'theme';
            const btn = document.getElementById('themeToggleProfile');
            const iconSun = document.getElementById('iconSunProfile');
            const iconMoon = document.getElementById('iconMoonProfile');

            function reflectIcons(theme){
                const isDark = theme === 'dark';
                iconMoon.classList.toggle('hidden', !isDark); // luna visible en oscuro
                iconSun.classList.toggle('hidden', isDark);   // sol visible en claro
                btn?.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            }

            function setTheme(theme){
                document.documentElement.dataset.theme = theme;                 // variables CSS
                document.documentElement.classList.toggle('dark', theme === 'dark'); // Tailwind dark:
                localStorage.setItem(KEY, theme);
                reflectIcons(theme);
            }

            function current(){
                return localStorage.getItem(KEY) || 'dark';
            }

            // Inicializa según preferencia actual
            reflectIcons(current());

            btn?.addEventListener('click', () => {
                const next = current() === 'dark' ? 'light' : 'dark';
                setTheme(next);
            });
        })();
    </script>
</x-app-layout>
