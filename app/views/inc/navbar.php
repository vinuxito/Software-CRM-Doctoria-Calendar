<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?php echo URLROOT; ?>">Panel
            <span class="visually-hidden">(actual)</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
      <?php if(isset($_SESSION['user_id'])) : ?>
        <li class="nav-item">
            <a class="nav-link" href="#">Bienvenido(a) <?php echo $_SESSION['user_name']; ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Cerrar Sesión</a>
        </li>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Registrarse</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Iniciar Sesión</a>
        </li>
      <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
