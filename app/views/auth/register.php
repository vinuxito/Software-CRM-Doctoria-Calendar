<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Crear Cuenta</h2>
            <p>Completa el formulario para registrarte</p>
            <form action="<?php echo URLROOT; ?>/users/register" method="post">
                <div class="form-group mb-3">
                    <label for="name">Nombre: <sup>*</sup></label>
                    <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                    <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Correo Electrónico: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Teléfono:</label>
                    <input type="text" name="phone" class="form-control form-control-lg" value="<?php echo $data['phone'] ?? ''; ?>" placeholder="+57 300 000 0000">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Contraseña: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-group mb-3">
                    <label for="role">Rol: <sup>*</sup></label>
                    <select name="role" class="form-control form-control-lg">
                        <option value="cliente" <?php echo (($data['role'] ?? 'cliente') === 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                        <option value="medico" <?php echo (($data['role'] ?? '') === 'medico') ? 'selected' : ''; ?>>Médico</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password">Confirmar Contraseña: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Registrarse" class="btn btn-success btn-block w-100">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block w-100">¿Ya tienes cuenta? Inicia Sesión</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
