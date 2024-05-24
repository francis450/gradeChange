<?php

session_start();

// Include the autoloader
require_once 'autoload.php';

// Load configuration
require_once 'config/config.php';

$router = new Router(new Request);

$router->get('/', 'AuthController@login');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');

$router->resolve();
