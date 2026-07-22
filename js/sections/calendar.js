// Doctoria CRM — Calendar Section JS Module
'use strict';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var dbEvents = JSON.parse(calendarEl.getAttribute('data-events') || '[]');

    var formattedEvents = dbEvents
    .filter(function (event) {
        var title = (event.title || '').toLowerCase();
        return title !== 'disponible';
    })
    .map(function (event, index) {
        var teal = index % 2 === 0;
        if (event.status === 'pending') {
            teal = true;
        }
        return {
            title: event.title || 'Cita',
            start: event.start_date,
            end: event.end_date,
            color: event.status === 'approved' ? '#e7f0ff' : (event.status === 'rejected' ? '#fdebec' : (teal ? '#eef9f8' : '#e7f0ff')),
            textColor: event.status === 'approved' ? '#2f5faa' : (event.status === 'rejected' ? '#b83a4b' : (teal ? '#00a29a' : '#2f5faa')),
            extendedProps: {
                status: event.status || '',
                doctorName: event.doctor_name || '',
                doctorId: event.doctor_id || '',
                doctorPhone: event.doctor_phone || '',
                patientName: event.patient_name || '',
                patientId: event.patient_id || '',
                patientPhone: event.patient_phone || '',
                contactPhone: event.contact_phone || '',
                description: event.description || ''
            }
        };
    });

    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var modal = document.getElementById('calendar-modal');
    var modalClose = document.getElementById('calendar-modal-close');
    var modalStart = document.getElementById('modal-start');
    var modalEnd = document.getElementById('modal-end');
    var modalTitle = document.getElementById('modal-title');
    var modalDescription = document.getElementById('modal-description');
    var modalAppointmentId = document.getElementById('modal-appointment-id');
    var modalAction = document.getElementById('modal-appointment-action');
    var modalDelete = document.getElementById('calendar-modal-delete');
    var modalSave = document.getElementById('calendar-modal-save');
    var modalDoctor = document.getElementById('modal-doctor');
    var modalPatient = document.getElementById('modal-patient');
    var modalContactPhone = document.getElementById('modal-contact-phone');

    function toLocalInputValue(date) {
        var d = new Date(date.getTime() - (date.getTimezoneOffset() * 60000));
        return d.toISOString().slice(0, 16);
    }

    function openModal(start, end, eventData) {
        if (!modal || !modalStart || !modalEnd) {
            return;
        }
        if (eventData) {
            modalAppointmentId.value = eventData.id || 0;
            modalTitle.value = eventData.title || 'Nueva cita';
            modalDescription.value = eventData.extendedProps.description || '';
            if (modalDoctor) {
                modalDoctor.value = eventData.extendedProps.doctorId || modalDoctor.value;
            }
            if (modalPatient) {
                modalPatient.value = eventData.extendedProps.patientId || modalPatient.value;
            }
            if (modalContactPhone) {
                modalContactPhone.value = eventData.extendedProps.contactPhone || '';
            }
            modalAction.value = 'save';
            if (modalDelete) {
                modalDelete.style.display = 'inline-flex';
            }
            if (modalSave) {
                modalSave.textContent = 'Actualizar cita';
            }
        } else {
            modalAppointmentId.value = 0;
            modalTitle.value = 'Nueva cita';
            modalDescription.value = '';
            if (modalDoctor) {
                modalDoctor.selectedIndex = 0;
            }
            if (modalPatient) {
                modalPatient.selectedIndex = 0;
            }
            if (modalContactPhone) {
                modalContactPhone.value = '';
            }
            modalAction.value = 'save';
            if (modalDelete) {
                modalDelete.style.display = 'none';
            }
            if (modalSave) {
                modalSave.textContent = 'Guardar cita';
            }
        }
        modalStart.value = toLocalInputValue(start);
        modalEnd.value = toLocalInputValue(end);
        modal.classList.add('active');
    }

    function closeModal() {
        if (modal) {
            modal.classList.remove('active');
        }
    }

    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    if (modalDelete) {
        modalDelete.addEventListener('click', function () {
            if (modalAppointmentId && Number(modalAppointmentId.value) > 0) {
                modalAction.value = 'delete';
                modalDelete.closest('form').submit();
            }
        });
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        initialDate: new Date().toISOString().slice(0, 10),
        firstDay: 6,
        allDaySlot: false,
        selectable: true,
        slotMinTime: '07:00:00',
        slotMaxTime: '20:00:00',
        slotDuration: '00:30:00',
        headerToolbar: false,
        dayHeaderFormat: { weekday: 'short', day: 'numeric' },
        nowIndicator: false,
        expandRows: true,
        events: formattedEvents,
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        eventContent: function(arg) {
            var doctorName = arg.event.extendedProps.doctorName || 'Sin médico';
            var patientName = arg.event.extendedProps.patientName || 'Sin cliente';
            var status = arg.event.extendedProps.status || '';
            var statusLabel = status ? status.toUpperCase() : '';
            return {
                html:
                    '<div class="fc-event-main-custom">' +
                        '<div class="fc-event-title-custom">' + arg.event.title + '</div>' +
                        '<div class="fc-event-meta">Cliente: ' + patientName + '</div>' +
                        '<div class="fc-event-meta">Tel cliente: ' + (arg.event.extendedProps.patientPhone || 'N/A') + '</div>' +
                        '<div class="fc-event-meta">Médico: ' + doctorName + '</div>' +
                        '<div class="fc-event-meta">Tel médico: ' + (arg.event.extendedProps.doctorPhone || 'N/A') + '</div>' +
                        (statusLabel ? '<div class="fc-event-status">' + statusLabel + '</div>' : '') +
                    '</div>'
            };
        },
        eventClick: function(info) {
            info.jsEvent.preventDefault();
            // Wrap FullCalendar event to mock expected format
            var mockEvent = {
                id: info.event.extendedProps.appointmentId || info.event.id || info.event.extendedProps.id || info.event._def.publicId,
                title: info.event.title,
                extendedProps: info.event.extendedProps
            };
            // Try fallback matching logic for ID
            if (!mockEvent.id) {
                var match = dbEvents.find(function(e) {
                    return e.title === info.event.title && e.start_date === info.event.startStr.slice(0, 19);
                });
                if (match) mockEvent.id = match.id;
            }
            openModal(info.event.start, info.event.end, mockEvent);
        },
        dateClick: function(info) {
            var start = new Date(info.date);
            var end = new Date(start.getTime() + 30 * 60000);
            openModal(start, end);
        },
        select: function(info) {
            openModal(info.start, info.end);
        }
    });

    function updateTitle() {
        var title = document.getElementById('crm-title');
        if (!title) return;
        var start = calendar.view.currentStart;
        var end = new Date(calendar.view.currentEnd.getTime() - 86400000);
        title.textContent = start.getDate() + ' - ' + end.getDate() + ' ' + months[end.getMonth()];
    }

    calendar.render();
    updateTitle();

    var btnPrev = document.getElementById('crm-prev');
    if (btnPrev) {
        btnPrev.addEventListener('click', function () {
            calendar.prev();
            updateTitle();
        });
    }

    var btnNext = document.getElementById('crm-next');
    if (btnNext) {
        btnNext.addEventListener('click', function () {
            calendar.next();
            updateTitle();
        });
    }

    var btnToday = document.getElementById('crm-today');
    if (btnToday) {
        btnToday.addEventListener('click', function () {
            calendar.today();
            updateTitle();
        });
    }
});
