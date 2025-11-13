{{-- resources/views/components/pagination.blade.php --}}
@props(['paginator', 'pageName' => 'page'])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de paginación" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Info de resultados y navegación móvil -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 flex-1">
            <!-- Información de resultados -->
            <div class="text-sm text-[var(--text-muted)]">
                Mostrando
                <span class="font-medium text-[var(--text)]">{{ $paginator->firstItem() ?? 0 }}</span>
                a
                <span class="font-medium text-[var(--text)]">{{ $paginator->lastItem() ?? 0 }}</span>
                de
                <span class="font-medium text-[var(--text)]">{{ $paginator->total() }}</span>
                resultados
            </div>

            <!-- Navegación móvil -->
            <div class="flex gap-2 sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg
                                 text-[var(--text-muted)] bg-[var(--background)] border border-[var(--border)]
                                 cursor-not-allowed opacity-50">
                        Anterior
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg
                              text-[var(--text)] bg-[var(--background)] border border-[var(--border)]
                              hover:bg-[var(--border)]/10 transition-colors">
                        Anterior
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg
                              text-[var(--text)] bg-[var(--background)] border border-[var(--border)]
                              hover:bg-[var(--border)]/10 transition-colors">
                        Siguiente
                    </a>
                @else
                    <span class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg
                                 text-[var(--text-muted)] bg-[var(--background)] border border-[var(--border)]
                                 cursor-not-allowed opacity-50">
                        Siguiente
                    </span>
                @endif
            </div>
        </div>

        <!-- Controles de paginación (Desktop) -->
        <div class="hidden sm:flex items-center gap-3">
            <!-- Selector de items por página -->
            <div class="flex items-center gap-2">
                <label for="per-page-{{ $pageName }}" class="text-sm text-[var(--text-muted)] whitespace-nowrap">
                    Por página:
                </label>
                <select id="per-page-{{ $pageName }}"
                        name="{{ $pageName === 'pending_page' ? 'pending_per_page' : 'active_per_page' }}"
                        onchange="this.form?.submit() || window.location.href = updateQueryStringParameter(window.location.href, this.name, this.value)"
                        class="px-2 py-1 text-sm rounded-lg border border-[var(--border)]
                               bg-[var(--background)] text-[var(--text)]
                               focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                               transition-all">
                    @foreach([10, 25, 50, 100] as $size)
                        <option value="{{ $size }}"
                                {{ $paginator->perPage() == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Números de página -->
            <div class="flex items-center rounded-lg shadow-sm border border-[var(--border)] overflow-hidden">
                {{-- Botón Anterior --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 bg-[var(--background)] text-[var(--text-muted)] cursor-not-allowed
                                 border-r border-[var(--border)]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 bg-[var(--background)] text-[var(--text)]
                              hover:bg-[var(--border)]/10 transition-colors border-r border-[var(--border)]
                              focus:z-10 focus:ring-2 focus:ring-inset focus:ring-[var(--primary)]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif

                {{-- Números de página --}}
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 text-sm font-bold text-white
                                     bg-gradient-to-r from-[var(--primary)] to-[var(--accent)]
                                     border-r border-[var(--primary)] last:border-r-0 z-10">
                            {{ $page }}
                        </span>
                    @elseif ($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 2)
                        <a href="{{ $url }}"
                           class="px-4 py-2 text-sm font-medium bg-[var(--background)] text-[var(--text)]
                                  hover:bg-[var(--border)]/10 transition-colors
                                  border-r border-[var(--border)] last:border-r-0
                                  focus:z-10 focus:ring-2 focus:ring-inset focus:ring-[var(--primary)]">
                            {{ $page }}
                        </a>
                    @elseif ($page == 2 || $page == $paginator->lastPage() - 1)
                        <span class="px-3 py-2 text-sm bg-[var(--background)] text-[var(--text-muted)]
                                     border-r border-[var(--border)]">
                            ...
                        </span>
                    @endif
                @endforeach

                {{-- Botón Siguiente --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 bg-[var(--background)] text-[var(--text)]
                              hover:bg-[var(--border)]/10 transition-colors
                              focus:z-10 focus:ring-2 focus:ring-inset focus:ring-[var(--primary)]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span class="px-3 py-2 bg-[var(--background)] text-[var(--text-muted)] cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>

            <!-- Ir a página -->
            <form method="GET" class="flex items-center gap-2">
                @foreach(request()->except($pageName) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <label class="text-sm text-[var(--text-muted)] whitespace-nowrap">Ir a:</label>
                <input type="number"
                       name="{{ $pageName }}"
                       min="1"
                       max="{{ $paginator->lastPage() }}"
                       value="{{ $paginator->currentPage() }}"
                       class="w-16 px-2 py-1 text-sm text-center rounded-lg border border-[var(--border)]
                              bg-[var(--background)] text-[var(--text)]
                              focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent"
                       onchange="this.form.submit()">
                <span class="text-sm text-[var(--text-muted)]">de {{ $paginator->lastPage() }}</span>
            </form>
        </div>
    </nav>

    <!-- JavaScript helper para actualizar query strings -->
    <script>
        function updateQueryStringParameter(uri, key, value) {
            const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            const separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                return uri.replace(re, '$1' + key + "=" + value + '$2');
            } else {
                return uri + separator + key + "=" + value;
            }
        }
    </script>
@endif
