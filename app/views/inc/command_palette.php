<!-- Command Palette Modal (Ctrl + K) -->
<div id="cmd-palette-modal" class="cmd-palette-overlay">
    <div class="cmd-palette-card">
        <div class="cmd-palette-search">
            <i class="fas fa-search"></i>
            <input type="text" id="cmd-palette-input" class="cmd-palette-input" placeholder="Buscar pacientes, citas, especialidades o comandos... (Esc para salir)" autocomplete="off">
            <span style="font-size: 11px; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; color: #64748b; font-weight: 600;">ESC</span>
        </div>
        <div id="cmd-palette-results" class="cmd-palette-results">
            <div class="cmd-group-title">Navegación Rápida</div>
            <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="cmd-item">
                <i class="far fa-calendar-alt"></i> <span>Agenda de Citas</span> <span class="cmd-badge">Ir a Agenda</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/patients" class="cmd-item">
                <i class="fas fa-notes-medical"></i> <span>Expedientes Clínicos</span> <span class="cmd-badge">Pacientes</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/doctors" class="cmd-item">
                <i class="fas fa-user-md"></i> <span>Especialistas</span> <span class="cmd-badge">Directorio</span>
            </a>
            <?php if (isset($data['user_role']) && $data['user_role'] === 'admin') : ?>
            <a href="<?php echo URLROOT; ?>/dashboard/invoices" class="cmd-item">
                <i class="fas fa-file-invoice-dollar"></i> <span>Facturación CFDI 4.0</span> <span class="cmd-badge">SAT</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/analytics" class="cmd-item">
                <i class="fas fa-chart-line"></i> <span>Analítica de Rehabilitación</span> <span class="cmd-badge">Reportes</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
