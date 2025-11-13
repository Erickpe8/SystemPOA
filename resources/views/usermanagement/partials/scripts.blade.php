{{-- resources/views/usermanagement/partials/scripts.blade.php --}}
<script>
    /**
     * User Management JavaScript
     * Handles all client-side interactions for user management
     */

    // ============================================
    // HELPER: Get CSRF Token
    // ============================================
    function getCsrfToken() {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            return metaToken.content;
        }

        const inputToken = document.querySelector('input[name="_token"]');
        if (inputToken) {
            return inputToken.value;
        }

        console.error('CSRF token not found');
        return null;
    }

    // ============================================
    // MODAL HANDLERS
    // ============================================

    /**
     * Open approval modal with user data
     */
    function openApprovalModal(userId, userName, userEmail) {
        console.log('🔵 Opening approval modal for user:', {
            userId,
            userName,
            userEmail
        });

        const userIdInput = document.getElementById('approve-user-id');
        const userNameEl = document.getElementById('approve-user-name');
        const userEmailEl = document.getElementById('approve-user-email');
        const avatarEl = document.getElementById('approve-user-avatar');

        if (userIdInput) userIdInput.value = userId;
        if (userNameEl) userNameEl.textContent = userName;
        if (userEmailEl) userEmailEl.textContent = userEmail;
        if (avatarEl) avatarEl.textContent = userName.charAt(0).toUpperCase();

        const form = document.getElementById('approve-form');
        if (form) {
            form.reset();
            if (userIdInput) userIdInput.value = userId;
        }

        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'approve-user-modal',
            bubbles: true,
            composed: true
        }));
    }

    /**
     * Open edit role modal with user data
     */
    function openEditRoleModal(userId, userName, currentRole, currentArea, isActive = true) {
        console.log('📝 Opening edit modal for user:', { userId, userName, currentRole, currentArea, isActive });

        const userIdInput = document.getElementById('edit-user-id');
        const userNameEl = document.getElementById('edit-user-name');
        const avatarEl = document.getElementById('edit-user-avatar');
        const currentRoleEl = document.getElementById('edit-current-role');
        const roleSelect = document.getElementById('edit-role');
        const areaInput = document.getElementById('edit-area');
        const isActiveCheckbox = document.getElementById('edit-is-active');
        const statusLabel = document.getElementById('edit-status-label');
        const statusBadge = document.getElementById('edit-user-status-badge');

        if (userIdInput) userIdInput.value = userId;
        if (userNameEl) userNameEl.textContent = userName;
        if (avatarEl) avatarEl.textContent = userName.charAt(0).toUpperCase();
        if (currentRoleEl) currentRoleEl.textContent = currentRole || 'Sin rol';
        if (roleSelect) roleSelect.value = currentRole || '';
        if (areaInput) areaInput.value = currentArea || '';

        // Configurar el toggle del estado
        if (isActiveCheckbox) {
            isActiveCheckbox.checked = isActive;
        }

        // Actualizar label del toggle
        if (statusLabel) {
            if (isActive) {
                statusLabel.innerHTML = '<span class="text-green-600 dark:text-green-400 font-semibold">Activo</span>';
            } else {
                statusLabel.innerHTML = '<span class="text-red-600 dark:text-red-400 font-semibold">Inactivo</span>';
            }
        }

        // Actualizar badge de estado en la tarjeta de usuario
        if (statusBadge) {
            if (isActive) {
                statusBadge.innerHTML = `
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                bg-green-500/20 text-green-700 dark:text-green-300
                                border border-green-500/30">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Activo
                    </span>
                `;
            } else {
                statusBadge.innerHTML = `
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                bg-red-500/20 text-red-700 dark:text-red-300
                                border border-red-500/30">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Inactivo
                    </span>
                `;
            }
        }

        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'edit-role-modal',
            bubbles: true
        }));
    }

    /**
     * Open reject modal with user data
     */
    function openRejectModal(userId, userName, userEmail) {
        console.log('🔴 Opening reject modal for user:', {
            userId,
            userName,
            userEmail
        });

        const userIdInput = document.getElementById('reject-user-id');
        const userNameEl = document.getElementById('reject-user-name');
        const userEmailEl = document.getElementById('reject-user-email');
        const avatarEl = document.getElementById('reject-user-avatar');

        if (userIdInput) userIdInput.value = userId;
        if (userNameEl) userNameEl.textContent = userName;
        if (userEmailEl) userEmailEl.textContent = userEmail;
        if (avatarEl) avatarEl.textContent = userName.charAt(0).toUpperCase();

        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'reject-user-modal',
            bubbles: true
        }));
    }

    /**
     * Open delete modal with user data
     */
    function openDeleteModal(userId, userName, userEmail) {
        console.log('🗑️ Opening delete modal for user:', {
            userId,
            userName,
            userEmail
        });

        const userIdInput = document.getElementById('delete-user-id');
        const userNameEl = document.getElementById('delete-user-name');
        const userEmailEl = document.getElementById('delete-user-email');
        const avatarEl = document.getElementById('delete-user-avatar');

        if (userIdInput) {
            userIdInput.value = userId;
            console.log('  ✓ Delete user ID set:', userId);
        }
        if (userNameEl) {
            userNameEl.textContent = userName;
            console.log('  ✓ Delete user name set:', userName);
        }
        if (userEmailEl) {
            userEmailEl.textContent = userEmail;
            console.log('  ✓ Delete user email set:', userEmail);
        }
        if (avatarEl) {
            avatarEl.textContent = userName.charAt(0).toUpperCase();
            console.log('  ✓ Delete avatar set');
        }

        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'delete-user-modal',
            bubbles: true
        }));
    }

    /**
     * Delete user - ahora abre el modal en lugar de confirm
     */
    function deleteUser(userId, userName, userEmail = '') {
        openDeleteModal(userId, userName, userEmail);
    }

    /**
     * Close modal by name
     */
    function closeModal(modalName) {
        console.log('Closing modal:', modalName);
        window.dispatchEvent(new CustomEvent('close-modal', {
            detail: modalName,
            bubbles: true
        }));
    }

    // ============================================
    // API CALLS
    // ============================================

    /**
     * Approve user and assign role
     */
    async function handleApprovalSubmit(e) {
        e.preventDefault();
        console.log('📝 Form submitted - Approving user');

        const form = e.target;
        const formData = new FormData(form);
        const userId = document.getElementById('approve-user-id').value;
        const role = formData.get('role');
        const area = formData.get('area');
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!userId) {
            window.notify?.show('ID de usuario no encontrado', 'error');
            return;
        }

        if (!role) {
            window.notify?.show('Por favor selecciona un rol', 'error');
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
            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                throw new Error('CSRF token no encontrado');
            }

            const response = await fetch(`/user-management/${userId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    role: role,
                    area: area || null
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('approve-user-modal');
                window.notify?.show(data.message || 'Usuario aprobado correctamente', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al aprobar usuario');
            }
        } catch (error) {
            console.error('❌ Error:', error);
            window.notify?.show(error.message || 'Error de conexión', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    /**
     * Update user role and status
     */
    async function submitEditRoleForm(event) {
        event.preventDefault();

        const userId = document.getElementById('edit-user-id').value;
        const role = document.getElementById('edit-role').value;
        const area = document.getElementById('edit-area').value;
        const isActive = document.getElementById('edit-is-active').checked;
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!userId || !role) {
            window.notify?.show('Datos incompletos', 'error');
            return;
        }

        console.log('📤 Submitting edit role form:', { userId, role, area, isActive });

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
            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                throw new Error('CSRF token no encontrado');
            }

            const response = await fetch(`/user-management/${userId}/update-role`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    role: role,
                    area: area || null,
                    is_active: isActive
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('edit-role-modal');
                window.notify?.show(data.message || 'Usuario actualizado correctamente', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al actualizar usuario');
            }
        } catch (error) {
            console.error('❌ Error:', error);
            window.notify?.show(error.message || 'Error de conexión', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }


    /**
     * Reject user registration
     */
    async function confirmRejectUser() {
        const userId = document.getElementById('reject-user-id').value;
        const userName = document.getElementById('reject-user-name').textContent;
        const confirmBtn = document.getElementById('reject-confirm-btn');

        if (!userId) {
            window.notify?.show('ID de usuario no encontrado', 'error');
            return;
        }

        console.log('🗑️ Rejecting user:', {
            userId,
            userName
        });

        confirmBtn.disabled = true;
        const originalHTML = confirmBtn.innerHTML;
        confirmBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Rechazando...</span>
        `;

        try {
            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                throw new Error('CSRF token no encontrado');
            }

            const response = await fetch(`/user-management/${userId}/reject`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('reject-user-modal');
                window.notify?.show(data.message || 'Solicitud rechazada', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al rechazar usuario');
            }
        } catch (error) {
            console.error('Error:', error);
            window.notify?.show(error.message || 'Error al rechazar usuario', 'error');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalHTML;
        }
    }

    /**
     * Confirm delete user permanently (Called from delete modal)
     */
    async function confirmDeleteUser() {
        const userId = document.getElementById('delete-user-id').value;
        const userName = document.getElementById('delete-user-name').textContent;
        const confirmBtn = document.getElementById('delete-confirm-btn');

        if (!userId) {
            window.notify?.show('ID de usuario no encontrado', 'error');
            return;
        }

        console.log('🗑️ Deleting user permanently:', {
            userId,
            userName
        });

        confirmBtn.disabled = true;
        const originalHTML = confirmBtn.innerHTML;
        confirmBtn.innerHTML = `
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Eliminando...</span>
        `;

        try {
            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                throw new Error('CSRF token no encontrado');
            }

            const response = await fetch(`/user-management/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('delete-user-modal');
                window.notify?.show(data.message || 'Usuario eliminado correctamente', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al eliminar usuario');
            }
        } catch (error) {
            console.error('Error:', error);
            window.notify?.show(error.message || 'Error al eliminar usuario', 'error');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalHTML;
        }
    }

    // ============================================
    // NOTIFICATION SYSTEM
    // ============================================

    /**
     * Show notification toast
     */
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
    // UTILITY STYLES
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
            .animate-slide-in-right {
                animation: slide-in-right 0.3s ease-out;
            }
            .animate-slide-out-right {
                animation: slide-out-right 0.3s ease-in;
            }
        `;
        document.head.appendChild(style);
    }

    // ============================================
    // EVENT LISTENERS
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Initializing User Management Scripts');

        const approveForm = document.getElementById('approve-form');
        if (approveForm) {
            approveForm.addEventListener('submit', handleApprovalSubmit);
            console.log('✓ Approve form listener attached');
        }

        const editRoleForm = document.getElementById('edit-role-form');
        if (editRoleForm) {
            editRoleForm.addEventListener('submit', submitEditRoleForm);
            console.log('✓ Edit role form listener attached');
        }

        console.log('✅ User Management Scripts Loaded');
        console.log('🔑 CSRF Token available:', !!getCsrfToken());
    });
</script>
