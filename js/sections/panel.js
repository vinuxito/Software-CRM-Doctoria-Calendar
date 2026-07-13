// Doctoria CRM — Panel Section JS Module
'use strict';

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('panel-record-modal');
    var closeBtn = document.getElementById('panel-record-close');
    var records = document.querySelectorAll('.panel-record');
    var searchInput = document.getElementById('panel-live-search');
    var searchableRecords = document.querySelectorAll('.panel-searchable');
    var title = document.getElementById('panel-detail-title');
    var patient = document.getElementById('panel-detail-patient');
    var patientPhone = document.getElementById('panel-detail-patient-phone');
    var doctor = document.getElementById('panel-detail-doctor');
    var doctorPhone = document.getElementById('panel-detail-doctor-phone');
    var status = document.getElementById('panel-detail-status');
    var description = document.getElementById('panel-detail-description');

    function openModal(record) {
        if (!title || !patient || !modal) return;
        title.textContent = record.dataset.title || '';
        patient.textContent = record.dataset.patient || '';
        patientPhone.textContent = record.dataset.patientPhone || 'N/A';
        doctor.textContent = record.dataset.doctor || '';
        doctorPhone.textContent = record.dataset.doctorPhone || 'N/A';
        status.textContent = (record.dataset.status || '').toUpperCase();
        description.textContent = record.dataset.description || 'Sin descripción';
        modal.classList.add('active');
    }

    function closeModal() {
        if (modal) modal.classList.remove('active');
    }

    records.forEach(function (record) {
        record.addEventListener('click', function (event) {
            if (event.target.closest('form,button,a,input')) {
                return;
            }
            openModal(record);
        });
    });

    function runSearch() {
        if (!searchInput) return;
        var query = (searchInput.value || '').trim().toLowerCase();
        searchableRecords.forEach(function (item) {
            var txt = (item.textContent || '').toLowerCase();
            item.style.display = query === '' || txt.indexOf(query) !== -1 ? '' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', runSearch);
    }

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
