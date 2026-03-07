<?php
define('APP_DIR', __DIR__);
define('DATA_DIR', APP_DIR . '/data');
define('BASE_URL', '');

session_start();

spl_autoload_register(function ($class) {
    $file = APP_DIR . '/lib/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

require_once APP_DIR . '/lib/helpers.php';
