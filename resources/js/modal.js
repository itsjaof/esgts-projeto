// Sistema de Modal
document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById("modal-overlay");
    const openModalBtn = document.getElementById("open-modal-btn");
    const closeModalBtn = document.getElementById("close-modal-btn");
    const cancelBtn = document.getElementById("cancel-btn");
    const statusToggle = document.getElementById("status-toggle");
    const statusText = document.getElementById("status-text");
    const addEmployeeForm = document.getElementById("add-employee-form");

    // Verificar se os elementos existem
    if (!modalOverlay || !addEmployeeForm) {
        return;
    }

    // Toggle de status
    function updateStatusText() {
        if (statusToggle && statusText) {
            if (statusToggle.checked) {
                statusText.textContent = "Empregado ativo";
            } else {
                statusText.textContent = "Empregado inativo";
            }
        }
    }

    // Abrir modal
    if (openModalBtn) {
        openModalBtn.addEventListener("click", () => {
            if (modalOverlay) {
                modalOverlay.classList.add("active");
                document.body.style.overflow = "hidden";
            }
        });
    }

    // Fechar modal
    function closeModal() {
        if (modalOverlay) {
            modalOverlay.classList.remove("active");
        }
        document.body.style.overflow = "";
        if (addEmployeeForm) {
            addEmployeeForm.reset();
        }
        if (statusToggle) {
            statusToggle.checked = false;
            updateStatusText();
        }
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", closeModal);
    }
    if (cancelBtn) {
        cancelBtn.addEventListener("click", closeModal);
    }

    // Fechar ao clicar no overlay
    if (modalOverlay) {
        modalOverlay.addEventListener("click", (e) => {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });
    }

    // Fechar com ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modalOverlay && modalOverlay.classList.contains("active")) {
            closeModal();
        }
    });

    // Toggle de status
    if (statusToggle) {
        statusToggle.addEventListener("change", updateStatusText);
    }

    // Submeter formulário de edição
    if (addEmployeeForm) {
        addEmployeeForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(addEmployeeForm);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/empregados`;

            // Adicionar CSRF token
            const csrfToken = document.querySelector('input[name="_token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.value;
                form.appendChild(csrfInput);
            }

            // Adicionar method spoofing
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'POST';
            form.appendChild(methodInput);

            // Adicionar campos do formulário
            formData.forEach((value, key) => {
                if (key !== '_token' && key !== '_method' && key !== 'user_id') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }
            });

            // Adicionar status
            if (statusToggle) {
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = statusToggle.checked ? 'Ativo' : 'Inativo';
                form.appendChild(statusInput);
            }

            document.body.appendChild(form);
            form.submit();
        });
    }
});

// Sistema de Modal de Edição
document.addEventListener('DOMContentLoaded', () => {
    const editModalOverlay = document.getElementById("edit-modal-overlay");
    const closeEditModalBtn = document.getElementById("close-edit-modal-btn");
    const cancelEditBtn = document.getElementById("cancel-edit-btn");
    const editStatusToggle = document.getElementById("edit-status-toggle");
    const editStatusText = document.getElementById("edit-status-text");
    const editEmployeeForm = document.getElementById("edit-employee-form");

    // Verificar se os elementos existem
    if (!editModalOverlay || !editEmployeeForm) {
        return;
    }

    // Toggle de status de edição
    function updateEditStatusText() {
        if (editStatusToggle && editStatusText) {
            if (editStatusToggle.checked) {
                editStatusText.textContent = "Empregado ativo";
            } else {
                editStatusText.textContent = "Empregado inativo";
            }
        }
    }

    // Abrir modal de edição usando event delegation
    document.addEventListener('click', (e) => {
        const editButton = e.target.closest('.edit-user-btn');
        if (!editButton) return;

        e.preventDefault();
        e.stopPropagation();

        const userId = editButton.getAttribute('data-user-id');
        const userName = editButton.getAttribute('data-user-name');
        const userEmail = editButton.getAttribute('data-user-email');
        const userPosition = editButton.getAttribute('data-user-position');
        const userStatus = editButton.getAttribute('data-user-status');

        // Preencher o formulário com os dados do utilizador
        const editUserId = document.getElementById('edit-user-id');
        const editNomeCompleto = document.getElementById('edit-nome-completo');
        const editEmail = document.getElementById('edit-email');
        const editCargo = document.getElementById('edit-cargo');
        const editIdInterno = document.getElementById('edit-id-interno');

        document.getElementById("admin-option").setAttribute("hidden", "");
        if (editUserId) editUserId.value = userId || '';
        if (editNomeCompleto) editNomeCompleto.value = userName || '';
        if (editEmail) editEmail.value = userEmail || '';
        if (editCargo) editCargo.value = userPosition ? userPosition.charAt(0).toUpperCase() + userPosition.slice(1) : '';
        if (editIdInterno) editIdInterno.value = `EMP${userId}`;

        // Definir o status
        if (editStatusToggle) {
            const isActive = userStatus === 'Ativo';
            editStatusToggle.checked = isActive;
            updateEditStatusText();
        }

        // Definir a action do form
        if (editEmployeeForm) {
            editEmployeeForm.action = `/empregados/${userId}`;
        }

        // Abrir modal
        if (editModalOverlay) {
            editModalOverlay.classList.add("active");
            document.body.style.overflow = "hidden";
        }
    });

    // Fechar modal de edição
    function closeEditModal() {
        if (editModalOverlay) {
            editModalOverlay.classList.remove("active");
        }
        document.body.style.overflow = "";
        if (editEmployeeForm) {
            editEmployeeForm.reset();
        }
        if (editStatusToggle) {
            editStatusToggle.checked = false;
            updateEditStatusText();
        }
    }

    if (closeEditModalBtn) {
        closeEditModalBtn.addEventListener("click", closeEditModal);
    }
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener("click", closeEditModal);
    }

    // Fechar ao clicar no overlay
    if (editModalOverlay) {
        editModalOverlay.addEventListener("click", (e) => {
            if (e.target === editModalOverlay) {
                closeEditModal();
            }
        });
    }

    // Fechar com ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && editModalOverlay && editModalOverlay.classList.contains("active")) {
            closeEditModal();
        }
    });

    // Toggle de status de edição
    if (editStatusToggle) {
        editStatusToggle.addEventListener("change", updateEditStatusText);
    }

    // Submeter formulário de edição
    if (editEmployeeForm) {
        editEmployeeForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(editEmployeeForm);
            const editUserId = document.getElementById('edit-user-id');
            const userId = editUserId ? editUserId.value : null;

            if (!userId) {
                console.error('ID do utilizador não encontrado');
                return;
            }

            // Criar um form oculto para enviar PUT request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/empregados/${userId}`;

            // Adicionar CSRF token
            const csrfToken = document.querySelector('input[name="_token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.value;
                form.appendChild(csrfInput);
            }

            // Adicionar method spoofing
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);

            // Adicionar campos do formulário
            formData.forEach((value, key) => {
                if (key !== '_token' && key !== '_method' && key !== 'user_id') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }
            });

            // Adicionar status
            if (editStatusToggle) {
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = editStatusToggle.checked ? 'Ativo' : 'Inativo';
                form.appendChild(statusInput);
            }

            document.body.appendChild(form);
            form.submit();
        });
    }
});

// Modal para forçar alteração de password (abre automaticamente se existir)
document.addEventListener('DOMContentLoaded', () => {
    const forcePasswordModal = document.getElementById('forcePasswordResetModal');
    if (forcePasswordModal) {
        forcePasswordModal.classList.add('active');
    }
});
