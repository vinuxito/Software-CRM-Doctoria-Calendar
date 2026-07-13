<?php
// Load Config
require_once 'config/config.php';

// Load Helpers
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate or retrieve CSRF token for the current session.
 */
function csrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field.
 */
function csrfField() {
    echo '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Verify the submitted CSRF token matches the session token.
 */
function verifyCsrfToken($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
}

// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'app/core/' . $className . '.php';
});
