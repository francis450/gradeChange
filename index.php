<?php

session_start();

require_once 'core/Router.php';

// autoload classes
require_once 'autoload.php';

$router = new Router(new Request);

$router->get('/', 'AuthController@index');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@verify');
$router->get('/logout', 'AuthController@logout');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@store');