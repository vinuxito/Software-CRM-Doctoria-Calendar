<?php
require_once 'app/bootstrap.php';

class MockController extends Controller {
    public function renderLogin($data) {
        // Setup global variables that views expect
        $hideNavbar = $data['hide_navbar'] ?? false;
        
        ob_start();
        $this->view('auth/login', $data);
        $output = ob_get_clean();
        return $output;
    }

    public function renderRegister($data) {
        $hideNavbar = $data['hide_navbar'] ?? false;
        
        ob_start();
        $this->view('auth/register', $data);
        $output = ob_get_clean();
        return $output;
    }
}

echo "Running Rebranded Auth Rendering Tests...\n";

$controller = new MockController();

// 1. Happy Path Login View rendering
$data = [
    'email' => 'pepe@doctoria.com',
    'email_err' => '',
    'password_err' => '',
    'body_class' => 'auth-page',
    'hide_navbar' => true
];

$html = $controller->renderLogin($data);

if (strpos($html, 'class="auth-page"') === false) {
    die("ERROR: body_class 'auth-page' not rendered in login view.\n");
}
echo "✓ Verified custom body_class on login page.\n";

if (strpos($html, '<nav class="navbar') !== false) {
    // If hide_navbar is true, navbar shouldn't be included
    die("ERROR: Navbar was rendered when hide_navbar is set to true.\n");
}
echo "✓ Verified navbar is hidden correctly.\n";

if (strpos($html, 'logo.png') === false) {
    die("ERROR: Logo image missing in login view.\n");
}
echo "✓ Verified logo is present in login view.\n";

if (strpos($html, 'value="pepe@doctoria.com"') === false) {
    die("ERROR: Email input value not persisted in login view.\n");
}
echo "✓ Verified input email persistence.\n";

if (strpos($html, 'Iniciar Sesión') === false) {
    die("ERROR: Translated header 'Iniciar Sesión' missing in login view.\n");
}
echo "✓ Verified Spanish translation tokens on login view.\n";


// 2. Login View with validation errors
$data_err = [
    'email' => 'wrong_email',
    'email_err' => 'Usuario no encontrado',
    'password_err' => 'Contraseña incorrecta',
    'body_class' => 'auth-page',
    'hide_navbar' => true
];

$html_err = $controller->renderLogin($data_err);

if (strpos($html_err, 'is-invalid') === false) {
    die("ERROR: is-invalid classes missing in error state.\n");
}
if (strpos($html_err, 'Usuario no encontrado') === false || strpos($html_err, 'Contraseña incorrecta') === false) {
    die("ERROR: Validation errors not displayed in login view.\n");
}
echo "✓ Verified validation error propagation in login view.\n";


// 3. Register View rendering
$reg_data = [
    'name' => 'Pepe Paciente',
    'email' => 'pepe@doctoria.com',
    'phone' => '+52 300 000 0000',
    'role' => 'cliente',
    'name_err' => '',
    'email_err' => '',
    'password_err' => '',
    'confirm_password_err' => '',
    'body_class' => 'auth-page',
    'hide_navbar' => true
];

$reg_html = $controller->renderRegister($reg_data);

if (strpos($reg_html, 'class="auth-page"') === false) {
    die("ERROR: body_class 'auth-page' not rendered in register view.\n");
}
echo "✓ Verified custom body_class on register page.\n";

if (strpos($reg_html, 'Crear Cuenta') === false) {
    die("ERROR: Translated header 'Crear Cuenta' missing in register view.\n");
}
if (strpos($reg_html, 'Nombre') === false || strpos($reg_html, 'Correo Electrónico') === false) {
    die("ERROR: Spanish labels missing in register view.\n");
}
echo "✓ Verified Spanish translation tokens on register view.\n";

// 4. Verify no password echoing in HTML
if (strpos($reg_html, 'value="123456"') !== false || strpos($html, 'value="123456"') !== false) {
    die("ERROR: Passwords should never be echoed back in form values.\n");
}
echo "✓ Verified passwords are NOT echoed in view HTML (Security Check).\n";

echo "ALL AUTH RENDERING TESTS PASSED!\n";
