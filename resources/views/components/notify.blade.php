<div id="notify"
    class="fixed top-4 right-4 z-50 hidden transition-all duration-300 ease-in-out -translate-y-2 opacity-0">
    <div id="notify-card"
        class="max-w-md w-[92vw] sm:w-[460px] rounded-xl shadow-2xl border-l-8
               bg-[var(--card)] border-[color:var(--border)]">
        <div class="p-4 flex items-center gap-3">
            <div id="notify-icon-wrap"
                class="inline-flex items-center justify-center w-9 h-9 rounded-full
                       bg-[color:var(--border)]/40 shrink-0">
                <svg id="notify-icon" class="w-10 h-10 text-[var(--accent)]" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
            </div>

            <p id="notify-message" class="flex-1 text-[var(--text)] font-semibold text-base sm:text-lg leading-snug">
            </p>

            <button type="button" id="notify-close"
                class="ml-1 sm:ml-2 inline-flex items-center justify-center
                           text-[color:var(--text)]/60 hover:text-[var(--text)]
                           transition-colors shrink-0"
                aria-label="Cerrar">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
