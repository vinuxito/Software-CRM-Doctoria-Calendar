<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $section = $data['section'] ?? 'calendar'; ?>
<div class="crm-calendar-shell">
    <nav class="icon-sidebar">
        <div class="brand-icon">
            <img src="<?php echo URLROOT; ?>/img/logo.png" alt="Logo">
        </div>
        <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="nav-icon <?php echo $section === 'calendar' ? 'active' : ''; ?>" title="Calendario"><i class="far fa-calendar-alt"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/doctors" class="nav-icon <?php echo $section === 'doctors' ? 'active' : ''; ?>" title="Especialistas"><i class="far fa-user"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/chat" class="nav-icon <?php echo $section === 'chat' ? 'active' : ''; ?>" title="Mensajería"><i class="far fa-comment"></i></a>
        <a href="<?php echo URLROOT; ?>/dashboard/panel" class="nav-icon <?php echo $section === 'panel' ? 'active' : ''; ?>" title="Panel de control"><i class="far fa-chart-bar"></i></a>
        <?php if (in_array($data['user_role'], ['admin', 'medico'], true)) : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/patients" class="nav-icon <?php echo $section === 'patients' ? 'active' : ''; ?>" title="Expedientes Clínicos"><i class="fas fa-notes-medical"></i></a>
        <?php endif; ?>
        <?php if ($data['user_role'] === 'admin') : ?>
        <a href="<?php echo URLROOT; ?>/dashboard/users" class="nav-icon <?php echo $section === 'users' ? 'active' : ''; ?>" title="Control de Usuarios"><i class="fas fa-users"></i></a>
        <?php endif; ?>
        <div class="bottom-actions">
            <a href="<?php echo URLROOT; ?>/dashboard/settings" class="nav-icon <?php echo $section === 'settings' ? 'active' : ''; ?>" title="Configuración"><i class="fas fa-cog"></i></a>
            <a href="<?php echo URLROOT; ?>/dashboard/profile" class="user-avatar user-avatar-link <?php echo $section === 'profile' ? 'active' : ''; ?>" title="Perfil"><?php echo strtoupper(substr($data['user_name'], 0, 1)); ?></a>
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
        <?php else : ?>
            <?php require APPROOT . '/views/dashboard/sections/panel.php'; ?>
        <?php endif; ?>
    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
