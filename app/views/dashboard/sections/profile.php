<?php $profile = $data['profile'] ?? null; ?>
<header class="toolbar">
    <div class="tol-left"><div class="date-title"><span>Perfil</span></div></div>
</header>
<section class="crm-content">
    <div class="profile-wrap">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar"><?php echo strtoupper(substr($data['user_name'], 0, 1)); ?></div>
                <div>
                    <div class="profile-name"><?php echo htmlspecialchars($profile->name ?? $data['user_name']); ?></div>
                    <div class="profile-mail"><?php echo htmlspecialchars($profile->email ?? ''); ?></div>
                </div>
            </div>
            <form action="<?php echo URLROOT; ?>/dashboard/profile" method="post">
                <?php csrfField(); ?>
                <div class="profile-grid">
                    <label><span>Nombre</span><input type="text" name="name" value="<?php echo htmlspecialchars($profile->name ?? $data['user_name']); ?>" required></label>
                    <label><span>Email</span><input type="email" name="email" value="<?php echo htmlspecialchars($profile->email ?? ''); ?>" required></label>
                    <label><span>Teléfono</span><input type="text" name="phone" value="<?php echo htmlspecialchars($profile->phone ?? ''); ?>"></label>
                    <label><span>Rol</span><input type="text" value="<?php $roleLabels = ['admin' => 'Administrador', 'medico' => 'Médico / Especialista', 'cliente' => 'Paciente']; echo htmlspecialchars($roleLabels[$profile->role ?? ''] ?? $profile->role ?? ''); ?>" readonly></label>
                </div>
                <div class="profile-grid" style="margin-top: 16px;">
                    <label><span>Nueva contraseña</span><input type="password" name="password" placeholder="Dejar vacío para mantener la actual" minlength="6"></label>
                    <label><span>Confirmar contraseña</span><input type="password" name="password_confirm" placeholder="Repetir nueva contraseña"></label>
                </div>
                <button type="submit" class="btn-configurar" style="margin-top: 16px;">Actualizar perfil</button>
            </form>
        </div>
    </div>
</section>
