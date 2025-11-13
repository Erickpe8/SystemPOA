@props([
    'id' => 'theme-toggle',
    'size' => 'md',
    'label' => 'Cambiar tema',
])

@php
    $sizes = [
        'md' => ['w' => 'w-16', 'h' => 'h-9', 'knob' => 'w-7 h-7', 'icon' => 'w-4 h-4'],
        'lg' => ['w' => 'w-20', 'h' => 'h-11', 'knob' => 'w-9 h-9', 'icon' => 'w-5 h-5'],
    ];
    $sz = $sizes[$size] ?? $sizes['md'];
@endphp

<label class="theme-toggle-wrapper relative inline-flex items-center cursor-pointer select-none group"
    aria-label="{{ $label }}" data-size="{{ $size }}">
    {{-- input controlador (peer) --}}
    <input id="{{ $id }}-input" type="checkbox" class="sr-only" aria-label="{{ $label }}">

    {{-- pista (track) --}}
    <span
        class="track relative {{ $sz['w'] }} {{ $sz['h'] }} rounded-full overflow-hidden
                 transition-all duration-300 flex items-center px-1
                 shadow-md hover:shadow-xl
                 ring-2 ring-transparent group-hover:ring-[var(--accent)]/30
                 group-focus-visible:ring-[var(--accent)]">
        {{-- Ícono luna (izq) -> solo DARK --}}
        <span
            class="icon-moon absolute left-1.5 inline-flex items-center justify-center {{ $sz['icon'] }}
                     opacity-0 transition-all duration-300">
            <svg viewBox="0 0 384 512" class="{{ $sz['icon'] }} fill-current">
                <path
                    d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z" />
            </svg>
        </span>

        {{-- Ícono sol (der) -> solo LIGHT --}}
        <span
            class="icon-sun absolute right-1.5 inline-flex items-center justify-center {{ $sz['icon'] }}
                     opacity-100 transition-all duration-300">
            <svg viewBox="0 0 24 24" class="{{ $sz['icon'] }}" fill="none">
                <g fill="currentColor">
                    <circle r="5" cy="12" cx="12"></circle>
                    <path
                        d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z" />
                </g>
            </svg>
        </span>

        {{-- Knob --}}
        <span
            class="knob relative z-10 {{ $sz['knob'] }} rounded-full
                     shadow-lg transform-gpu transition-all duration-300
                     group-hover:scale-105"></span>
    </span>
</label>

@once
    <style>
        /* === COLORES BASE === */
        .theme-toggle-wrapper .track {
            background: linear-gradient(135deg, #89b4d9 0%, #5a9fd4 100%);
        }

        .theme-toggle-wrapper .knob {
            background: #fdfbf7;
        }

        .theme-toggle-wrapper .icon-sun {
            color: #d4a574;
        }

        /* === DARK MODE === */
        html.dark .theme-toggle-wrapper .track {
            background: linear-gradient(135deg, #2c4a6b 0%, #1e3a5f 100%);
        }

        html.dark .theme-toggle-wrapper .knob {
            background: #e8dfd1;
        }

        html.dark .theme-toggle-wrapper .icon-moon {
            color: #a3c4e0;
        }

        /* === MOVIMIENTO DEL KNOB === */
        /* md */
        label[data-size="md"]>input:checked+.track .knob {
            transform: translateX(1.75rem);
        }

        /* lg */
        label[data-size="lg"]>input:checked+.track .knob {
            transform: translateX(2.25rem);
        }

        /* Hover scale */
        label[data-size="md"]:hover>input:checked+.track .knob,
        label[data-size="md"]>input:checked+.track .knob:hover {
            transform: translateX(1.75rem) scale(1.05);
        }

        label[data-size="lg"]:hover>input:checked+.track .knob,
        label[data-size="lg"]>input:checked+.track .knob:hover {
            transform: translateX(2.25rem) scale(1.05);
        }

        /* === CONMUTACIÓN DE ICONOS === */
        label>input:checked+.track .icon-sun {
            opacity: 0;
            transform: scale(0.8) rotate(-90deg);
        }

        label>input:checked+.track .icon-moon {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        label>input:not(:checked)+.track .icon-sun {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        label>input:not(:checked)+.track .icon-moon {
            opacity: 0;
            transform: scale(0.8) rotate(90deg);
        }

        /* === HOVER EFFECTS === */
        .theme-toggle-wrapper:hover .track {
            filter: brightness(1.05);
        }

        .theme-toggle-wrapper:active .track {
            transform: scale(0.98);
        }

        /* === ANIMACIONES === */
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes tilt {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-5deg);
            }

            75% {
                transform: rotate(5deg);
            }
        }

        /* Animación sutil al cambiar */
        label>input+.track {
            animation: none;
        }

        label>input:checked+.track {
            animation: tilt 0.3s ease-in-out;
        }
    </style>

    <script>
        (function() {
            function applyTheme(theme) {
                document.documentElement.dataset.theme = theme;
                document.documentElement.classList.toggle('dark', theme === 'dark');
                localStorage.setItem('theme', theme);

                // Sincronizar todos los toggles
                document.querySelectorAll('[id$="-input"][id*="theme-toggle"]').forEach(inp => {
                    if (inp) inp.checked = (theme === 'dark');
                });
            }

            function currentTheme() {
                return localStorage.getItem('theme') || 'light';
            }

            window.theme = {
                apply: applyTheme,
                toggle: () => applyTheme(currentTheme() === 'dark' ? 'light' : 'dark'),
                init: () => applyTheme(currentTheme())
            };

            // Inicialización inmediata
            window.theme.init();

            // Delegación de eventos
            document.addEventListener('change', (e) => {
                if (e.target &&
                    e.target.id &&
                    e.target.id.includes('theme-toggle') &&
                    e.target.type === 'checkbox') {
                    window.theme.apply(e.target.checked ? 'dark' : 'light');
                }
            }, true);
        })
        ();
    </script>
@endonce
