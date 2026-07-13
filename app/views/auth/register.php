<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="auth-container">
    <div class="auth-brand">
        <img src="<?php echo URLROOT; ?>/img/logo.png" alt="<?php echo SITENAME; ?>">
        <h1><?php echo SITENAME; ?></h1>
        <p>Gestión clínica inteligente</p>
    </div>
    <div class="auth-card">
        <h2>Crear Cuenta</h2>
        <p>Completa el formulario para registrarte</p>
        <form action="<?php echo URLROOT; ?>/users/register" method="post">
            <div class="form-group mb-3">
                <label for="name">Nombre: <sup>*</sup></label>
                <input type="text" name="name" id="name" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="email">Correo Electrónico: <sup>*</sup></label>
                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="phone">Teléfono:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $data['phone'] ?? ''; ?>" placeholder="+52 300 000 0000">
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña: <sup>*</sup></label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="role">Rol: <sup>*</sup></label>
                <select name="role" id="role" class="form-control">
                    <option value="cliente" <?php echo (($data['role'] ?? 'cliente') === 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                    <option value="medico" <?php echo (($data['role'] ?? '') === 'medico') ? 'selected' : ''; ?>>Médico</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password">Confirmar Contraseña: <sup>*</sup></label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
            </div>
            <div class="d-grid gap-2 mt-4">
                <input type="submit" value="Registrarse" class="btn-auth-primary">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn-auth-secondary">¿Ya tienes cuenta? Inicia Sesión</a>
            </div>
        </form>
    </div>
    <div class="auth-footer">Doctoria CRM &copy; <?php echo date('Y'); ?></div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
