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
            <div class="profile-grid">
                <label><span>Nombre</span><input type="text" value="<?php echo htmlspecialchars($profile->name ?? $data['user_name']); ?>"></label>
                <label><span>Email</span><input type="email" value="<?php echo htmlspecialchars($profile->email ?? ''); ?>"></label>
                <label><span>Teléfono</span><input type="text" value="+57 300 000 0000"></label>
                <label><span>Especialidad</span><input type="text" value="Medicina general"></label>
            </div>
            <button class="btn-outline setting-save">Actualizar perfil</button>
        </div>
    </div>
</section>
