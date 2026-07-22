<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $section = $data['section'] ?? 'calendar'; ?>
<div class="crm-calendar-shell">
    <nav class="icon-sidebar">
        <div class="brand-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="Logo">
            <span class="brand-title">Doctoria</span>
        </div>
        
        <!-- Command Palette Trigger Button -->
        <button type="button" id="open-cmd-palette-btn" class="nav-icon" style="background: #f8fafc; border: 1px solid var(--border-default); cursor: pointer; text-align: left;" title="Buscar (Ctrl + K)">
            <i class="fas fa-search" style="color: var(--brand-primary);"></i>
            <span class="nav-label" style="font-size: 13px; color: var(--text-secondary);">Buscar... <kbd style="font-size: 10px; background: #e2e8f0; color: #475569; padding: 1px 4px; border-radius: 3px;">Ctrl+K</kbd></span>
        </button>

        <a href="<?php echo URLROOT; ?>/dashboard/panel" class="nav-icon <?php echo $section === 'panel' ? 'active' : ''; ?>" title="Panel de control"><i class="fas fa-chart-line"></i><span class="nav-label">Panel</span></a>
        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="nav-icon <?php echo $section === 'calendar' ? 'active' : ''; ?>" title="Agenda de Citas"><i class="far fa-calendar-alt"></i><span class="nav-label">Agenda</span></a>
        
        <?php if (in_array($data['user_role'] ?? 'cliente', ['admin', 'medico'], true)) : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/patients" class="nav-icon <?php echo $section === 'patients' ? 'active' : ''; ?>" title="Expedientes Clínicos"><i class="fas fa-notes-medical"></i><span class="nav-label">Expedientes</span></a>
        <?php endif; ?>
        
        <a href="<?php echo URLROOT; ?>/dashboard/doctors" class="nav-icon <?php echo $section === 'doctors' ? 'active' : ''; ?>" title="Especialistas"><i class="fas fa-user-md"></i><span class="nav-label">Especialistas</span></a>
        
        <?php if (in_array($data['user_role'] ?? 'cliente', ['admin', 'medico'], true)) : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/invoices" class="nav-icon <?php echo $section === 'invoices' ? 'active' : ''; ?>" title="Facturación CFDI 4.0"><i class="fas fa-file-invoice-dollar"></i><span class="nav-label">Facturación</span></a>
        <a href="<?php echo URLROOT; ?>/dashboard/analytics" class="nav-icon <?php echo $section === 'analytics' ? 'active' : ''; ?>" title="Analítica Clínica"><i class="fas fa-chart-pie"></i><span class="nav-label">Analítica</span></a>
        <a href="<?php echo URLROOT; ?>/dashboard/resources" class="nav-icon <?php echo $section === 'resources' ? 'active' : ''; ?>" title="Recursos y Cubículos"><i class="fas fa-door-open"></i><span class="nav-label">Recursos</span></a>
        <?php endif; ?>

        <a href="<?php echo URLROOT; ?>/dashboard/chat" class="nav-icon <?php echo $section === 'chat' ? 'active' : ''; ?>" title="Mensajería"><i class="far fa-comment"></i><span class="nav-label">Mensajes</span></a>
        
        <?php if (($data['user_role'] ?? '') === 'admin') : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/users" class="nav-icon <?php echo $section === 'users' ? 'active' : ''; ?>" title="Control de Usuarios"><i class="fas fa-users-cog"></i><span class="nav-label">Usuarios</span></a>
        <?php endif; ?>

        <div class="bottom-actions">
            <a href="<?php echo URLROOT; ?>/dashboard/settings" class="nav-icon <?php echo $section === 'settings' ? 'active' : ''; ?>" title="Configuración"><i class="fas fa-cog"></i><span class="nav-label">Configuración</span></a>
            <a href="<?php echo URLROOT; ?>/dashboard/profile" class="user-avatar-link <?php echo $section === 'profile' ? 'active' : ''; ?>" title="Perfil">
                <div class="user-avatar"><?php echo strtoupper(substr($data['user_name'] ?? 'U', 0, 1)); ?></div>
                <span class="nav-label" style="font-size: 13px; font-weight: 600;"><?php echo htmlspecialchars($data['user_name'] ?? 'Usuario'); ?></span>
            </a>
        </div>
    </nav>

    <?php if ($section === 'calendar') : ?>
        <?php require APPROOT . '/views/dashboard/sections/calendar_aside.php'; ?>
    <?php endif; ?>

    <main class="main-view">
        <?php if (!empty($data['flash'])) : ?>
            <?php 
                $flashType = $data['flash_type'] ?? 'auto';
                if ($flashType === 'auto') {
                    $isError = preg_match('/(error|incorrecto|ya está|no puedes|no válido|campos obligatorios|completados)/i', $data['flash']);
                } else {
                    $isError = ($flashType === 'error');
                }
                $flashClass = $isError ? 'flash-bar flash-danger' : 'flash-bar flash-success';
                $flashIcon = $isError ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
            ?>
            <div class="<?php echo $flashClass; ?>">
                <i class="<?php echo $flashIcon; ?>"></i>
                <span><?php echo htmlspecialchars($data['flash']); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($section === 'calendar') : ?>
            <?php require APPROOT . '/views/dashboard/sections/calendar.php'; ?>
        <?php elseif ($section === 'doctors') : ?>
            <?php require APPROOT . '/views/dashboard/sections/doctors.php'; ?>
        <?php elseif ($section === 'chat') : ?>
            <?php require APPROOT . '/views/dashboard/sections/chat.php'; ?>
        <?php elseif ($section === 'settings') : ?>
            <?php require APPROOT . '/views/dashboard/sections/settings.php'; ?>
        <?php elseif ($section === 'profile') : ?>
            <?php require APPROOT . '/views/dashboard/sections/profile.php'; ?>
        <?php elseif ($section === 'patients') : ?>
            <?php require APPROOT . '/views/dashboard/sections/patients.php'; ?>
        <?php elseif ($section === 'users') : ?>
            <?php require APPROOT . '/views/dashboard/sections/users.php'; ?>
        <?php elseif ($section === 'invoices' && file_exists(APPROOT . '/views/dashboard/sections/invoices.php')) : ?>
            <?php require APPROOT . '/views/dashboard/sections/invoices.php'; ?>
        <?php elseif ($section === 'analytics' && file_exists(APPROOT . '/views/dashboard/sections/analytics.php')) : ?>
            <?php require APPROOT . '/views/dashboard/sections/analytics.php'; ?>
        <?php elseif ($section === 'resources' && file_exists(APPROOT . '/views/dashboard/sections/resources.php')) : ?>
            <?php require APPROOT . '/views/dashboard/sections/resources.php'; ?>
        <?php else : ?>
            <?php require APPROOT . '/views/dashboard/sections/panel.php'; ?>
        <?php endif; ?>
    </main>
</div>

<?php require APPROOT . '/views/inc/command_palette.php'; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
