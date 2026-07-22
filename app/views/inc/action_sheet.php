<!-- Mobile Slide-Up Action Sheet Modal -->
<div id="mobile-action-sheet-overlay" class="action-sheet-overlay" style="display: none;">
    <div class="action-sheet-card">
        <div class="action-sheet-handle"></div>
        <h3 class="action-sheet-title"><i class="fas fa-bolt" style="color: var(--brand-primary);"></i> Acciones Rápidas</h3>
        
        <div class="action-sheet-grid">
            <a href="<?php echo URLROOT; ?>/dashboard/calendar" class="action-sheet-btn">
                <i class="far fa-calendar-plus" style="color: #3b82f6;"></i>
                <span>Nueva Cita</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/patients" class="action-sheet-btn">
                <i class="fas fa-street-view" style="color: #ef4444;"></i>
                <span>Punto Dolor</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/pathways" class="action-sheet-btn">
                <i class="fab fa-whatsapp" style="color: #25d366;"></i>
                <span>WhatsApp Care</span>
            </a>
            <a href="<?php echo URLROOT; ?>/dashboard/telemed" class="action-sheet-btn">
                <i class="fas fa-video" style="color: #8b5cf6;"></i>
                <span>Teleconsulta</span>
            </a>
        </div>
        
        <button type="button" id="btn-close-action-sheet" class="action-sheet-close-btn">Cancelar</button>
    </div>
</div>
