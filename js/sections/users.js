// Doctoria CRM — Users Section JS Module
'use strict';

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('user-modal');
    var closeBtn = document.getElementById('user-modal-close');
    var addBtn = document.getElementById('btn-add-user');
    var editBtns = document.querySelectorAll('.btn-edit-user');
    
    var formAction = document.getElementById('user-form-action');
    var formId = document.getElementById('user-form-id');
    var formName = document.getElementById('user-form-name');
    var formEmail = document.getElementById('user-form-email');
    var formPhone = document.getElementById('user-form-phone');
    var formRole = document.getElementById('user-form-role');
    var formPassword = document.getElementById('user-form-password');
    var modalTitle = document.getElementById('user-modal-title');
    var passLabel = document.getElementById('user-form-pass-label');

    function openAddModal() {
        if (!modalTitle || !formAction) return;
        modalTitle.textContent = 'Crear Usuario';
        formAction.value = 'create';
        formId.value = '0';
        formName.value = '';
        formEmail.value = '';
        formPhone.value = '';
        formRole.value = 'cliente';
        formPassword.value = '';
        formPassword.required = true;
        if (passLabel) passLabel.textContent = 'Contraseña';
        modal.classList.add('active');
    }

    function openEditModal(btn) {
        if (!modalTitle || !formAction) return;
        modalTitle.textContent = 'Editar Usuario';
        formAction.value = 'update';
        formId.value = btn.dataset.id;
        formName.value = btn.dataset.name;
        formEmail.value = btn.dataset.email;
        formPhone.value = btn.dataset.phone;
        formRole.value = btn.dataset.role;
        formPassword.value = '';
        formPassword.required = false;
        if (passLabel) passLabel.textContent = 'Contraseña (dejar en blanco para mantener)';
        modal.classList.add('active');
    }

    function closeModal() {
        if (modal) modal.classList.remove('active');
    }

    if (addBtn) {
        addBtn.addEventListener('click', openAddModal);
    }
    
    // Also bind event to potential empty state buttons
    var addEmptyBtn = document.getElementById('btn-add-user-empty');
    if (addEmptyBtn) {
        addEmptyBtn.addEventListener('click', openAddModal);
    }

    editBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            openEditModal(btn);
        });
    });
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }
});
