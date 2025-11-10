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
        // Intenta obtener el token del meta tag primero
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            return metaToken.content;
        }

        // Si no existe, intenta del input del formulario
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
        console.log('Opening approval modal for user:', userId, userName, userEmail);

        document.getElementById('approve-user-id').value = userId;
        document.getElementById('approve-user-name').textContent = userName;
        document.getElementById('approve-user-email').textContent = userEmail;
        document.getElementById('approve-user-avatar').textContent = userName.charAt(0).toUpperCase();

        // Reset form
        document.getElementById('approve-form').reset();
        document.getElementById('approve-user-id').value = userId;

        // Open modal
        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'approve-user-modal'
        }));
    }

    /**
     * Open edit role modal with user data
     */
    function openEditRoleModal(userId, userName, currentRole, currentArea) {
        console.log('Opening edit modal for user:', userId, userName, currentRole, currentArea);

        document.getElementById('edit-user-id').value = userId;
        document.getElementById('edit-user-name').textContent = userName;
        document.getElementById('edit-user-avatar').textContent = userName.charAt(0).toUpperCase();
        document.getElementById('edit-current-role').textContent = currentRole || 'Sin rol';
        document.getElementById('edit-role').value = currentRole || '';
        document.getElementById('edit-area').value = currentArea || '';

        // Open modal
        document.dispatchEvent(new CustomEvent('open-modal', {
            detail: 'edit-role-modal'
        }));
    }

    /**
     * Close modal by name
     */
    function closeModal(modalName) {
        document.dispatchEvent(new CustomEvent('close-modal', {
            detail: modalName
        }));
    }

    // ============================================
    // API CALLS
    // ============================================

    /**
     * Approve user and assign role
     */
    document.getElementById('approve-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();

        console.log('Form submitted - Approving user');

        const formData = new FormData(e.target);
        const userId = document.getElementById('approve-user-id').value;
        const role = formData.get('role');
        const area = formData.get('area');
        const submitBtn = e.target.querySelector('button[type="submit"]');

        console.log('User ID:', userId);
        console.log('Role:', role);
        console.log('Area:', area);

        if (!userId) {
            showNotification('error', 'ID de usuario no encontrado');
            return;
        }

        if (!role) {
            showNotification('error', 'Por favor selecciona un rol');
            return;
        }

        // Disable button
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

            console.log('Sending request to:', `/user-management/${userId}/approve`);

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

            console.log('Response status:', response.status);

            const data = await response.json();
            console.log('Response data:', data);

            if (response.ok && data.success) {
                closeModal('approve-user-modal');
                showNotification('success', data.message || 'Usuario aprobado correctamente');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al aprobar usuario');
            }
        } catch (error) {
            console.error('Error completo:', error);
            showNotification('error', error.message || 'Error de conexión');

            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    });

    /**
     * Update user role
     */
    async function submitEditRoleForm(event) {
        event.preventDefault();

        const userId = document.getElementById('edit-user-id').value;
        const role = document.getElementById('edit-role').value;
        const area = document.getElementById('edit-area').value;
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');

        console.log('Updating role for user:', userId, 'Role:', role, 'Area:', area);

        if (!userId || !role) {
            showNotification('error', 'Datos incompletos');
            return;
        }

        // Disable button
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
                    area: area || null
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                closeModal('edit-role-modal');
                showNotification('success', data.message || 'Rol actualizado correctamente');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al actualizar rol');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('error', error.message || 'Error de conexión');

            // Re-enable button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        }
    }

    // Attach event listeners
    document.addEventListener('DOMContentLoaded', function() {
        const editRoleForm = document.getElementById('edit-role-form');
        if (editRoleForm) {
            editRoleForm.addEventListener('submit', submitEditRoleForm);
            console.log('Edit role form listener attached');
        }
    });

    /**
     * Reject user registration
     */
    async function rejectUser(userId, userName) {
        if (!confirm(
                `¿Estás seguro de rechazar la solicitud de ${userName}?\n\nEsta acción eliminará permanentemente al usuario.`
            )) {
            return;
        }

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
                showNotification('success', data.message || 'Solicitud rechazada');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al rechazar usuario');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('error', error.message || 'Error al rechazar usuario');
        }
    }

    /**
     * Delete user permanently
     */
    async function deleteUser(userId, userName) {
        if (!confirm(
                `⚠️ ATENCIÓN: ¿Estás seguro de eliminar a ${userName}?\n\nEsta acción es PERMANENTE e IRREVERSIBLE.\n\nSe eliminarán:\n• Toda su información personal\n• Sus archivos y documentos\n• Su historial de actividad\n• Todas sus configuraciones`
            )) {
            return;
        }

        // Double confirmation for safety
        if (!confirm(
                `⚠️ ÚLTIMA CONFIRMACIÓN\n\n¿Realmente deseas eliminar permanentemente a ${userName}?`
            )) {
            return;
        }

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
                showNotification('success', data.message || 'Usuario eliminado correctamente');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.error || data.message || 'Error al eliminar usuario');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('error', error.message || 'Error al eliminar usuario');
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

        // Auto remove
        setTimeout(() => {
            notification.classList.add('animate-slide-out-right');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ============================================
    // UTILITY STYLES
    // ============================================

    // Add animation styles if not present
    if (!document.getElementById('user-mgmt-animations')) {
        const style = document.createElement('style');
        style.id = 'user-mgmt-animations';
        style.textContent = `
            @keyframes slide-in-right {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slide-out-right {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
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

    // Log para debugging
    console.log('User Management Scripts Loaded');
    console.log('CSRF Token available:', !!getCsrfToken());
</script>
