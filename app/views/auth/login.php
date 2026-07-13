<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="auth-container">
    <div class="auth-brand">
        <img src="<?php echo URLROOT; ?>/img/logo.png" alt="<?php echo SITENAME; ?>">
        <h1><?php echo SITENAME; ?></h1>
        <p>Gestión clínica inteligente</p>
    </div>
    <div class="auth-card">
        <h2>Iniciar Sesión</h2>
        <p>Ingresa tus credenciales para acceder</p>
        <form action="<?php echo URLROOT; ?>/users/login" method="post">
            <?php csrfField(); ?>
            <div class="form-group mb-3">
                <label for="email">Email o Usuario: <sup>*</sup></label>
                <input type="text" name="email" id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña: <sup>*</sup></label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="d-grid gap-2 mt-4">
                <input type="submit" value="Iniciar Sesión" class="btn-auth-primary">
                <a href="<?php echo URLROOT; ?>/users/register" class="btn-auth-secondary">¿No tienes cuenta? Regístrate</a>
            </div>
        </form>
    </div>
    <div class="auth-footer">Doctoria CRM &copy; <?php echo date('Y'); ?></div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
