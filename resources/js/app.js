import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// =============== SystemPOA Notify ===============
window.notify = (function () {
    let timer = null;

    const el = () => document.getElementById('notify');
    const card = () => document.getElementById('notify-card');
    const icon = () => document.getElementById('notify-icon');
    const iconWrap = () => document.getElementById('notify-icon-wrap');
    const message = () => document.getElementById('notify-message');
    const closeBtn = () => document.getElementById('notify-close');

    // Mapas por tipo
    const types = {
        success: { border: '#16a34a', accent: '#16a34a', svg: 'M5 13l4 4L19 7' },
        error: { border: '#dc2626', accent: '#dc2626', svg: 'M6 18L18 6M6 6l12 12' },
        warning: { border: '#f59e0b', accent: '#f59e0b', svg: 'M12 9v4m0 4h.01' },
        info: { border: '#2563eb', accent: '#2563eb', svg: 'M13 16h-1v-4h-1m1-4h.01' },
    };

    function setIcon(pathD) {
        icon().innerHTML = '';
        const p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        p.setAttribute('stroke-linecap', 'round');
        p.setAttribute('stroke-linejoin', 'round');
        p.setAttribute('stroke-width', '2');
        p.setAttribute('d', pathD);
        icon().appendChild(p);
    }

    function show(msg, type = 'info', timeout = 5000) {
        const t = types[type] || types.info;
        message().textContent = msg;

        // bordes y colores
        card().style.borderLeftColor = t.border;
        icon().style.color = t.accent;
        iconWrap().style.backgroundColor = t.border + '22';

        // icono
        setIcon(t.svg);

        // animacion
        const n = el();
        n.classList.remove('hidden');
        requestAnimationFrame(() => {
            n.classList.remove('opacity-0', '-translate-y-2');
            n.classList.add('opacity-100', 'translate-y-0');
        });

        // autocierre
        if (timer) clearTimeout(timer);
        if (timeout > 0) timer = setTimeout(hide, timeout);
    }

    function hide() {
        const n = el();
        n.classList.add('opacity-0', '-translate-y-2');
        n.classList.remove('opacity-100', 'translate-y-0');
        if (timer) clearTimeout(timer);
        timer = setTimeout(() => n.classList.add('hidden'), 250);
    }

    // Click en la X
    document.addEventListener('DOMContentLoaded', () => {
        const btn = closeBtn();
        if (btn) btn.addEventListener('click', hide);
    });

    return { show, hide };
})();
