<?php
spl_autoload_register(function ($class) {
    $directories = [
        'core/',
        'controllers/',
        'models/',
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});