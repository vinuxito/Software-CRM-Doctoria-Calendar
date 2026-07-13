<header class="toolbar">
    <div class="tol-left">
        <button id="crm-today" class="btn-outline">Esta semana</button>
        <button id="crm-prev" class="inline-nav">❮</button>
        <button id="crm-next" class="inline-nav">❯</button>
        <div class="date-title"><span id="crm-title">Cargando...</span></div>
    </div>
    <div class="tol-right">
        <div class="panel-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Buscar citas o pacientes...">
        </div>
        <select class="btn-outline"><option>Todos los consultorios</option></select>
        <select class="btn-outline"><option>Todos los especialistas</option></select>
        <button class="btn-outline"><i class="fas fa-filter"></i></button>
    </div>
</header>
<section class="crm-content">
    <div class="calendar-card">
        <div id="calendar" class="crm-fc" data-events='<?php echo json_encode($data['appointments'] ?? []); ?>'></div>
    </div>
</section>

<!-- Modal for Quick Create/Update Appointment -->
<div id="calendar-modal" class="calendar-modal-overlay">
    <div class="calendar-modal-card">
        <div class="calendar-modal-head">
            <h3>Detalle de la cita</h3>
            <button type="button" id="calendar-modal-close" class="calendar-modal-close">×</button>
        </div>
        <form action="<?php echo URLROOT; ?>/dashboard/calendar" method="post" class="calendar-modal-form">
            <input type="hidden" name="appointment_action" id="modal-appointment-action" value="save">
            <input type="hidden" name="appointment_id" id="modal-appointment-id" value="0">
            <label>Título de la cita</label>
            <input type="text" name="title" id="modal-title" placeholder="Ej. Consulta de Nutrición" required>
            <div class="form-grid-2">
                <div>
                    <label>Médico especialista</label>
                    <select name="doctor_id" id="modal-doctor" required>
                        <option value="">Selecciona médico</option>
                        <?php foreach (($data['doctors'] ?? []) as $doctor) : ?>
                            <option value="<?php echo (int)$doctor->id; ?>"><?php echo htmlspecialchars($doctor->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Paciente</label>
                    <select name="patient_id" id="modal-patient" required>
                        <option value="">Selecciona paciente</option>
                        <?php foreach (($data['clients'] ?? []) as $patient) : ?>
                            <option value="<?php echo (int)$patient->id; ?>"><?php echo htmlspecialchars($patient->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-grid-2">
                <div>
                    <label>Fecha y hora de inicio</label>
                    <input type="datetime-local" name="start_date" id="modal-start" required>
                </div>
                <div>
                    <label>Fecha y hora de fin</label>
                    <input type="datetime-local" name="end_date" id="modal-end" required>
                </div>
            </div>
            <label>Número de contacto</label>
            <input type="text" name="contact_phone" id="modal-contact-phone" placeholder="+57 300 000 0000">
            <label>Descripción</label>
            <textarea name="description" id="modal-description" placeholder="Detalle de la cita"></textarea>
            <div class="calendar-modal-actions">
                <button type="button" id="calendar-modal-delete" class="btn-chat">Eliminar</button>
                <button type="submit" id="calendar-modal-save" class="btn-configurar">Guardar cita</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo URLROOT; ?>/js/sections/calendar.js"></script>
