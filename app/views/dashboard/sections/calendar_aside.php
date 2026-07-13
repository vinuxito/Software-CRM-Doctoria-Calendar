<aside class="controls-panel">
    <div class="panel-header">
        <div class="brand-mini-icon"><i class="fas fa-layer-group"></i></div>
        <div class="month-title">Marzo 2026</div>
        <div class="nav-arrows"><span>❮</span><span>❯</span></div>
    </div>
    <div class="mini-cal">
        <div class="mini-day-name">Lun</div><div class="mini-day-name">Mar</div><div class="mini-day-name">Mié</div><div class="mini-day-name">Jue</div><div class="mini-day-name">Vie</div><div class="mini-day-name">Sáb</div><div class="mini-day-name">Dom</div>
        <div class="mini-day-num muted">23</div><div class="mini-day-num muted">24</div><div class="mini-day-num muted">25</div><div class="mini-day-num muted">26</div><div class="mini-day-num muted">27</div><div class="mini-day-num muted">28</div><div class="mini-day-num muted">1</div>
        <div class="mini-day-num">2</div><div class="mini-day-num">3</div><div class="mini-day-num">4</div><div class="mini-day-num">5</div><div class="mini-day-num">6</div><div class="mini-day-num">7</div><div class="mini-day-num">8</div>
        <div class="mini-day-num">9</div><div class="mini-day-num">10</div><div class="mini-day-num">11</div><div class="mini-day-num">12</div><div class="mini-day-num">13</div><div class="mini-day-num active">14</div><div class="mini-day-num">15</div>
        <div class="mini-day-num">16</div><div class="mini-day-num">17</div><div class="mini-day-num">18</div><div class="mini-day-num">19</div><div class="mini-day-num">20</div><div class="mini-day-num">21</div><div class="mini-day-num">22</div>
        <div class="mini-day-num">23</div><div class="mini-day-num">24</div><div class="mini-day-num">25</div><div class="mini-day-num">26</div><div class="mini-day-num">27</div><div class="mini-day-num">28</div><div class="mini-day-num">29</div>
    </div>
    <ul class="action-links">
        <li class="action-link"><i class="fas fa-level-up-alt"></i><span>Lista de espera</span><span class="new-tag">NUEVO</span></li>
        <li class="action-link action-link-danger"><i class="far fa-calendar-times"></i><span>Bloquear fechas</span></li>
    </ul>
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
