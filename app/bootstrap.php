<?php
// Load Config
require_once 'config/config.php';

// Load Helpers
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'app/core/' . $className . '.php';
});
