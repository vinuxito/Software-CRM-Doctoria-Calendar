<header class="toolbar">
    <div class="tol-left"><div class="date-title"><span>Especialistas disponibles</span></div></div>
</header>
<section class="crm-content doctors-reference">
    <?php if (empty($data['doctors'])) : ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-user-md"></i></div>
            <h4>No hay especialistas registrados</h4>
            <p>Los médicos aparecerán aquí cuando un administrador los registre en el sistema.</p>
        </div>
    <?php else : ?>
        <div class="doctor-grid">
            <?php
                $images = [
                    URLROOT . '/../img/doctor1.png',
                    URLROOT . '/../img/doctor2.png',
                    URLROOT . '/../img/doctor3.png',
                    URLROOT . '/../img/doctor4.png'
                ];
            ?>
            <?php foreach (($data['doctors'] ?? []) as $idx => $doctor) : ?>
                <article class="doctor-card ref">
                    <div class="doctor-thumb" style="background-image:url('<?php echo $images[$idx % count($images)]; ?>')"></div>
                    <div class="doctor-body">
                        <div class="doctor-name"><?php echo htmlspecialchars($doctor->name); ?></div>
                        <div class="doctor-role">Doctor</div>
                        <div class="doctor-rate">★★★★★ <span>(<?php echo 80 + ($idx * 7); ?>)</span></div>
                        <div class="doctor-actions">
                            <a class="btn-agendar" href="<?php echo URLROOT; ?>/dashboard/calendar?doctor=<?php echo (int)$doctor->id; ?>"><i class="far fa-calendar-alt"></i> Agendar</a>
                            <a class="btn-chat" href="<?php echo URLROOT; ?>/dashboard/chat?with=<?php echo (int)$doctor->id; ?>"><i class="far fa-comment"></i> Chat</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
