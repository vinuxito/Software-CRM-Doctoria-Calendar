<?php $section = $data['section'] ?? 'calendar'; ?>
<!-- Mobile Couch Remote Bottom Navigation Bar -->
<div class="mobile-bottom-nav">
    <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="mobile-nav-item <?php echo $section === 'calendar' ? 'active' : ''; ?>">
        <i class="far fa-calendar-alt"></i>
        <span>Agenda</span>
    </a>
    <a href="<?php echo URLROOT; ?>/dashboard/patients" class="mobile-nav-item <?php echo $section === 'patients' ? 'active' : ''; ?>">
        <i class="fas fa-notes-medical"></i>
        <span>Pacientes</span>
    </a>
    
    <!-- Central Action FAB Button -->
    <button type="button" id="btn-open-action-sheet" class="mobile-nav-fab" title="Acciones Rápidas">
        <i class="fas fa-bolt"></i>
    </button>

    <a href="<?php echo URLROOT; ?>/dashboard/chat" class="mobile-nav-item <?php echo $section === 'chat' ? 'active' : ''; ?>">
        <i class="far fa-comment"></i>
        <span>Mensajes</span>
    </a>
    <a href="<?php echo URLROOT; ?>/dashboard/profile" class="mobile-nav-item <?php echo $section === 'profile' ? 'active' : ''; ?>">
        <i class="fas fa-user"></i>
        <span>Perfil</span>
    </a>
</div>
