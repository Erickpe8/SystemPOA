{{-- resources/views/usermanagement/partials/scripts.blade.php --}}
<script>
    /**
     * User Management JavaScript - Versión Final
     * Gestión completa sin recargas de página
     */

    // ============================================
    // HELPER: Get CSRF Token
    // ============================================
    function getCsrfToken() {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) return metaToken.content;

        const inputToken = document.querySelector('input[name="_token"]');
        if (inputToken) return inputToken.value;

        console.error('CSRF token not found');
        return null;
    }

    // ============================================
    // BÚSQUEDA Y FILTROS EN TIEMPO REAL
    // ============================================

    /**
     * Búsqueda de usuarios pendientes
     */
    document.getElementById('search-pending')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.pending-user-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.userName || '';
            const email = card.dataset.userEmail || '';
            const matches = name.includes(searchTerm) || email.includes(searchTerm);

            card.style.display = matches ? 'block' : 'none';
            if (matches) visibleCount++;
        });

        // Mostrar mensaje de "no encontrado"
        const noResults = document.getElementById('no-results-pending');
        const grid = document.getElementById('pending-users-grid');

        if (visibleCount === 0 && searchTerm !== '') {
            grid?.classList.add('hidden');
            noResults?.classList.remove('hidden');
        } else {
            grid?.classList.remove('hidden');
            noResults?.classList.add('hidden');
        }

        // Actualizar contador
        updatePendingCount(visibleCount);
    });

    /**
     * Búsqueda de usuarios activos
     */
    document.getElementById('search-active')?.addEventListener('input', function(e) {
        filterActiveUsers();
    });

    /**
     * Filtro por rol
     */
    document.getElementById('filter-role')?.addEventListener('change', function(e) {
        filterActiveUsers();
    });

    /**
     * Función unificada de filtrado para usuarios activos
     */
    function filterActiveUsers() {
        const searchTerm = document.getElementById('search-active')?.value.toLowerCase().trim() || '';
        const roleFilter = document.getElementById('filter-role')?.value.toLowerCase() || '';
        const rows = document.querySelectorAll('.active-user-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.dataset.userName || '';
            const email = row.dataset.userEmail || '';
            const role = row.dataset.userRole || '';
            const area = row.dataset.userArea || '';

            const matchesSearch = name.includes(searchTerm) ||
                                email.includes(searchTerm) ||
                                area.includes(searchTerm);
            const matchesRole = !roleFilter || role === roleFilter;

            const matches = matchesSearch && matchesRole;
            row.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        // Mostrar/ocultar mensaje de "no encontrado"
        const noResults = document.getElementById('no-results-active');
        const tbody = document.getElementById('active-users-tbody');

        if (visibleCount === 0) {
            noResults?.classList.remove('hidden');
            tbody?.querySelectorAll('.active-user-row').forEach(row => row.style.display = 'none');
        } else {
            noResults?.classList.add('hidden');
        }

        updateActiveCount(visibleCount);
    }

    /**
     * Actualizar contador de usuarios pendientes
     */
    function updatePendingCount(count) {
        const counter = document.getElementById('pending-count');
        if (counter) {
            counter.textContent = count;
        }
    }

    /**
     * Actualizar contador de usuarios activos
     */
    function updateActiveCount(count) {
        const counter = document.getElementById('active-count');
        if (counter) {
            counter.textContent = count;
        }
    }

    // ============================================
    // MODAL HANDLERS
    // ============================================

    /**
     * Abrir modal de aprobación
     */
    function openApprovalModal(userId, userName, userEmail) {
        document.getElementById('approve-user-id').value = userId;
        document.getElementById('approve-user-name').textContent = userName;
        document.getElementById('approve-user-email').textContent = userEmail;
        document.getElementById('approve-user-avatar').textContent = userName.charAt(0).toUpperCase();

        // Reset form
        document.getElementById('approve-form').reset();
        document.getElementById('approve-user-id').value = userId;

        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'approve-user-modal'
        }));
    }

    /**
     * Abrir modal de rechazo
     */
    function openRejectModal(userId, userName, userEmail) {
        document.getElementById('reject-user-id').value = userId;
        document.getElementById('reject-user-name').textContent = userName;
        document.getElementById('reject-user-email').textContent = userEmail;
        document.getElementById('reject-user-avatar').textContent = userName.charAt(0).toUpperCase();

        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'reject-user-modal'
        }));
    }

    /**
     * Abrir modal de edición de rol
     */
    function openEditRoleModal(userId, userName, currentRole, currentArea) {
        document.getElementById('edit-user-id').value = userId;
        document.getElementById('edit-user-name').textContent = userName;
        document.getElementById('edit-user-avatar').textContent = userName.charAt(0).toUpperCase();
        document.getElementById('edit-current-role').textContent = currentRole || 'Sin rol';
        document.getElementById('edit-role').value = currentRole || '';
        document.getElementById('edit-area').value = currentArea || '';

        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'edit-role-modal'
        }));
    }

    /**
     * Abrir modal de eliminación
     */
    function openDeleteModal(userId, userName) {
        document.getElementById('delete-user-id').value = userId;
        document.getElementById('delete-user-name').textContent = userName;
        document.getElementById('delete-user-avatar').textContent = userName.charAt(0).toUpperCase();

        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'delete-user-modal'
        }));
    }

    /**
     * Cerrar modal
     */
    function closeModal(modalName) {
        document.dispatchEvent(new CustomEvent('close-modal', {
            detail: modalName
        }));
    }

    // ============================================
    // API CALLS - APROBAR USUARIO
    // ============================================

    async function submitApprovalForm(event) {
        event.preventDefault();

        const userId = document.getElementById('approve-user-id').value;
        const role = document.getElementById('approve-role').value;
        const area = document.getElementById('approve-area').value;
        const userName = document.getElementById('approve-user-name').textContent;
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!userId || !role) {
            showNotification('error', 'Datos incompletos');
            return;
        }

        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Procesando...</span>
        `;

        try {
            const response = await fetch(`/user-management/${userId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ role, area: area || null })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('approve-user-modal');
                showNotification('success', data.message);

                // Remover tarjeta del DOM
                removePendingUserCard(userId);

                // Agregar a usuarios activos
                addActiveUserRow(data.user);

                // Actualizar contadores en el header
                updateHeaderCounters();
            } else {
                throw new Error(data.error || 'Error al aprobar usuario');
            }
        } catch (error) {
            showNotification('error', error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    // ============================================
    // API CALLS - RECHAZAR USUARIO
    // ============================================

    async function confirmRejectUser() {
        const userId = document.getElementById('reject-user-id').value;
        const userName = document.getElementById('reject-user-name').textContent;
        const submitBtn = event.target;

        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Procesando...</span>
        `;

        try {
            const response = await fetch(`/user-management/${userId}/reject`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('reject-user-modal');
                showNotification('success', data.message);

                // Remover del DOM
                removePendingUserCard(userId);
                updateHeaderCounters();
            } else {
                throw new Error(data.error || 'Error al rechazar usuario');
            }
        } catch (error) {
            showNotification('error', error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    // ============================================
    // API CALLS - ACTUALIZAR ROL
    // ============================================

    async function submitEditRoleForm(event) {
        event.preventDefault();

        const userId = document.getElementById('edit-user-id').value;
        const role = document.getElementById('edit-role').value;
        const area = document.getElementById('edit-area').value;
        const userName = document.getElementById('edit-user-name').textContent;
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!userId || !role) {
            showNotification('error', 'Datos incompletos');
            return;
        }

        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Actualizando...</span>
        `;

        try {
            const response = await fetch(`/user-management/${userId}/update-role`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ role, area: area || null })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('edit-role-modal');
                showNotification('success', data.message);

                // Actualizar fila en el DOM
                updateActiveUserRow(userId, data.user);
            } else {
                throw new Error(data.error || 'Error al actualizar rol');
            }
        } catch (error) {
            showNotification('error', error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    // ============================================
    // API CALLS - ELIMINAR USUARIO
    // ============================================

    async function confirmDeleteUser() {
        const userId = document.getElementById('delete-user-id').value;
        const userName = document.getElementById('delete-user-name').textContent;
        const submitBtn = event.target;

        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Eliminando...</span>
        `;

        try {
            const response = await fetch(`/user-management/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('delete-user-modal');
                showNotification('success', data.message);

                // Remover del DOM
                removeActiveUserRow(userId);
                updateHeaderCounters();
            } else {
                throw new Error(data.error || 'Error al eliminar usuario');
            }
        } catch (error) {
            showNotification('error', error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    // ============================================
    // DOM MANIPULATION - SIN RECARGAS
    // ============================================

    /**
     * Remover tarjeta de usuario pendiente
     */
    function removePendingUserCard(userId) {
        const card = document.querySelector(`.pending-user-card[data-user-id="${userId}"]`);
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            setTimeout(() => card.remove(), 300);
        }

        // Verificar si quedan usuarios pendientes
        setTimeout(() => {
            const remaining = document.querySelectorAll('.pending-user-card').length;
            if (remaining === 0) {
                showEmptyPendingState();
            }
        }, 350);
    }

    /**
     * Mostrar estado vacío de pendientes
     */
    function showEmptyPendingState() {
        const grid = document.getElementById('pending-users-grid');
        if (grid) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-500/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-[var(--text)] mb-1">
                        No hay solicitudes pendientes
                    </h4>
                    <p class="text-sm text-[var(--text-muted)]">
                        Todas las solicitudes han sido procesadas
                    </p>
                </div>
            `;
        }
    }

    /**
     * Agregar usuario a la tabla de activos
     */
    function addActiveUserRow(user) {
        const tbody = document.getElementById('active-users-tbody');
        if (!tbody) return;

        const roleDisplay = user.roles && user.roles.length > 0
            ? `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                     bg-[var(--primary)]/10 text-[var(--primary)] border border-[var(--primary)]/20">
                    ${user.roles.join(', ')}
               </span>`
            : `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                     bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-500/20">
                    Sin rol
               </span>`;

        const newRow = document.createElement('tr');
        newRow.className = 'active-user-row hover:bg-[var(--border)]/5 transition-colors duration-150';
        newRow.dataset.userId = user.id;
        newRow.dataset.userName = user.name.toLowerCase();
        newRow.dataset.userEmail = user.email.toLowerCase();
        newRow.dataset.userRole = user.role_name || '';
        newRow.dataset.userArea = (user.area || '').toLowerCase();
        newRow.style.opacity = '0';

        newRow.innerHTML = `
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)]
                            flex items-center justify-center text-white font-bold shrink-0">
                        ${user.name.charAt(0)}
                    </div>
                    <div class="min-w-0">
                        <div class="font-medium text-[var(--text)] truncate">${user.name}</div>
                        <div class="text-sm text-[var(--text-muted)] truncate md:hidden">${user.email}</div>
                    </div>
                </div>
            </td>
            <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[var(--text-secondary)]">${user.email}</div>
            </td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">${roleDisplay}</td>
            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-[var(--text-secondary)]">${user.area || 'N/A'}</div>
            </td>
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                <div class="flex items-center justify-end gap-2">
                    <button onclick="openEditRoleModal(${user.id}, '${user.name}', '${user.role_name}', '${user.area || ''}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                               bg-blue-500/10 text-blue-600 dark:text-blue-400
                               hover:bg-blue-500/20 text-xs font-medium transition-all
                               border border-blue-500/20 hover:border-blue-500/40">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="hidden sm:inline">Editar</span>
                    </button>
                    <button onclick="openDeleteModal(${user.id}, '${user.name}')"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                               bg-red-500/10 text-red-600 dark:text-red-400
                               hover:bg-red-500/20 text-xs font-medium transition-all
                               border border-red-500/20 hover:border-red-500/40">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Eliminar</span>
                    </button>
                </div>
            </td>
        `;

        tbody.insertBefore(newRow, tbody.firstChild);

        // Animar entrada
        setTimeout(() => {
            newRow.style.transition = 'opacity 0.3s, transform 0.3s';
            newRow.style.opacity = '1';
        }, 50);
    }

    /**
     * Actualizar fila de usuario activo
     */
    function updateActiveUserRow(userId, user) {
        const row = document.querySelector(`.active-user-row[data-user-id="${userId}"]`);
        if (!row) return;

        // Actualizar datasets
        row.dataset.userRole = user.role_name || '';
        row.dataset.userArea = (user.area || '').toLowerCase();

        // Actualizar rol visible
        const roleCell = row.querySelector('td:nth-child(3)');
        if (roleCell && user.roles) {
            const roleDisplay = user.roles.length > 0
                ? `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         bg-[var(--primary)]/10 text-[var(--primary)] border border-[var(--primary)]/20">
                        ${user.roles.join(', ')}
                   </span>`
                : `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-500/20">
                        Sin rol
                   </span>`;
            roleCell.innerHTML = roleDisplay;
        }

        // Actualizar área
        const areaCell = row.querySelector('td:nth-child(4)');
        if (areaCell) {
            areaCell.innerHTML = `<div class="text-sm text-[var(--text-secondary)]">${user.area || 'N/A'}</div>`;
        }

        // Efecto de actualización
        row.style.backgroundColor = 'rgba(34, 197, 94, 0.1)';
        setTimeout(() => {
            row.style.transition = 'background-color 0.5s';
            row.style.backgroundColor = '';
        }, 100);
    }

    /**
     * Remover fila de usuario activo
     */
    function removeActiveUserRow(userId) {
        const row = document.querySelector(`.active-user-row[data-user-id="${userId}"]`);
        if (row) {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => row.remove(), 300);
        }
    }

    /**
     * Actualizar contadores en el header
     */
    function updateHeaderCounters() {
        const pendingCount = document.querySelectorAll('.pending-user-card').length;
        const activeCount = document.querySelectorAll('.active-user-row').length;

        // Actualizar badges del header
        const headerBadges = document.querySelectorAll('[class*="px-3 py-1 rounded-full"]');
        headerBadges.forEach(badge => {
            if (badge.textContent.includes('Pendientes')) {
                badge.textContent = `${pendingCount} Pendientes`;
            } else if (badge.textContent.includes('Activos')) {
                badge.textContent = `${activeCount} Activos`;
            }
        });

        // Actualizar contadores internos
        updatePendingCount(pendingCount);
        updateActiveCount(activeCount);
    }

    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================

    function showNotification(type, message) {
        const colors = {
            success: {
                bg: 'bg-green-500',
                icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>`
            },
            error: {
                bg: 'bg-red-500',
                icon: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>`
            },
            info: {
                bg: 'bg-blue-500',
                icon: `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>`
            }
        };

        const config = colors[type] || colors.info;
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${config.bg} text-white px-5 py-3 rounded-lg shadow-2xl z-50
                                  flex items-center gap-3 animate-slide-in-right max-w-md`;
        notification.innerHTML = `
            <div class="shrink-0">${config.icon}</div>
            <p class="text-sm font-medium">${message}</p>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('animate-slide-out-right');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ============================================
    // STYLES
    // ============================================

    if (!document.getElementById('user-mgmt-animations')) {
        const style = document.createElement('style');
        style.id = 'user-mgmt-animations';
        style.textContent = `
            @keyframes slide-in-right {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slide-out-right {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .animate-slide-in-right { animation: slide-in-right 0.3s ease-out; }
            .animate-slide-out-right { animation: slide-out-right 0.3s ease-in; }
        `;
        document.head.appendChild(style);
    }
</script>
