<aside class="controls-panel">
    <div class="panel-header">
        <div class="brand-mini-icon"><i class="fas fa-layer-group"></i></div>
        <div class="month-title"><?php
            $meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
            echo ucfirst($meses[(int)date('n') - 1]) . ' ' . date('Y');
        ?></div>
    </div>
    <?php if (!empty($data['flash'])) : ?>
        <div class="calendar-flash"><?php echo htmlspecialchars($data['flash']); ?></div>
    <?php endif; ?>
    <?php if (!empty($data['can_schedule'])) : ?>
        <form action="<?php echo URLROOT; ?>/dashboard/calendar" method="post" class="quick-appointment-form">
            <?php csrfField(); ?>
            <input type="hidden" name="create_appointment" value="1">
            <input type="text" name="title" placeholder="Título de cita" required>
            <select name="doctor_id" required>
                <option value="">Selecciona médico</option>
                <?php foreach (($data['doctors'] ?? []) as $doctorItem) : ?>
                    <option value="<?php echo (int)$doctorItem->id; ?>"><?php echo htmlspecialchars($doctorItem->name); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="patient_id" required>
                <option value="">Selecciona cliente</option>
                <?php foreach (($data['clients'] ?? []) as $clientItem) : ?>
                    <option value="<?php echo (int)$clientItem->id; ?>"><?php echo htmlspecialchars($clientItem->name); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="resource_id">
                <option value="">Cubículo / Sin asignar</option>
                <?php foreach (($data['resources'] ?? []) as $resItem) : ?>
                    <option value="<?php echo (int)$resItem->id; ?>"><?php echo htmlspecialchars($resItem->name); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="quick-date-field">
                <label class="field-label" for="start_date">Desde</label>
                <input id="start_date" type="datetime-local" name="start_date" required>
            </div>
            <div class="quick-date-field">
                <label class="field-label" for="end_date">Hasta</label>
                <input id="end_date" type="datetime-local" name="end_date" required>
            </div>
            <input type="text" name="contact_phone" placeholder="Número de contacto">
            <textarea name="description" placeholder="Descripción"></textarea>
            <button type="submit" class="btn-configurar">Agendar cita</button>
        </form>
    <?php endif; ?>
    <div class="section-flat">Visitas de hoy <i class="fas fa-chevron-right"></i></div>
</aside>
