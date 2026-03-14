<?php
// Database params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'mysql');
define('DB_NAME', 'crm_doctoria');

// App Root
define('APPROOT', dirname(dirname(__FILE__)) . '/app');

// URL Root
// Try to auto-detect URLROOT
// This logic tries to find the URL of the public_html/CRM folder
if(isset($_SERVER['HTTP_HOST'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $path = dirname($script_name); 
    // Ensure no trailing slash
    $path = rtrim($path, '/');
    define('URLROOT', $protocol . "://" . $host . $path);
} else {
    // CLI Fallback
    define('URLROOT', 'http://localhost/public_html/CRM');
}
// define('URLROOT', 'http://localhost/public_html/CRM');

// Site Name
define('SITENAME', 'Doctoria CRM');
