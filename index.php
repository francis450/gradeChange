<?php

session_start();

require_once 'autoload.php';

require_once 'config/config.php';

$router = new Router(new Request);

$router->get('/', 'AuthController@login');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');
// dashboard
$router->get('/dashboard', 'DashboardController@index');
// users
$router->get('/users', 'UserController@index');
$router->get('/users/create', 'UserController@create');
$router->post('/users/store', 'UserController@store');
$router->get('/users/edit/{id}', 'UserController@edit');
$router->post('/users/update/{id}', 'UserController@update');
$router->get('/users/delete/{id}', 'UserController@delete');

// departments
$router->get('/departments', 'DepartmentController@index');
$router->get('/departments/create', 'DepartmentController@create');
$router->post('/departments/store', 'DepartmentController@store');
$router->get('/departments/edit/{id}', 'DepartmentController@edit');
$router->post('/departments/update/{id}', 'DepartmentController@update');
$router->get('/departments/delete/{id}', 'DepartmentController@delete');

$router->resolve();
