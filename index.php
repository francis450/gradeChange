<?php

session_start();

require_once 'autoload.php';

require_once 'config/config.php';

require_once 'middlewares/checkRole.php';

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
$router->get('/departments/delete/{id}', 'DepartmentController@delete', checkRole('admin'));

// Faculty
$router->get('/faculty', 'FacultyController@index');
$router->get('/faculty/create', 'FacultyController@create');
$router->post('/faculty/store', 'FacultyController@store');
$router->get('/faculty/edit/{id}', 'FacultyController@edit');
$router->post('/faculty/update/{id}', 'FacultyController@update');
$router->get('/faculty/delete/{id}', 'FacultyController@delete', checkRole('admin'));

// students 
$router->get('/students', 'StudentController@index');
$router->get('/students/create', 'StudentController@create');
$router->post('/students/store', 'StudentController@store');
$router->get('/students/edit/{id}', 'StudentController@edit');
$router->post('/students/update/{id}', 'StudentController@update');
$router->get('/students/delete/{id}', 'StudentController@delete', checkRole('admin'));

// courses
$router->get('/courses', 'CourseController@index');
$router->get('/courses/create', 'CourseController@create');
$router->post('/courses/store', 'CourseController@store');
$router->get('/courses/edit/{id}', 'CourseController@edit');
$router->post('/courses/update/{id}', 'CourseController@update');
$router->get('/courses/delete/{id}', 'CourseController@delete', checkRole('admin'));
$router->post('/courses/department', 'CourseController@department');
$router->post('/courses/students', 'CourseController@students');

// enrollments
$router->get('/enrollments', 'EnrollmentController@index');
$router->get('/enrollments/create', 'EnrollmentController@create');
$router->post('/enrollments/store', 'EnrollmentController@store');
$router->get('/enrollments/edit/{id}', 'EnrollmentController@edit');
$router->post('/enrollments/update/{id}', 'EnrollmentController@update');
$router->get('/enrollments/delete/{id}', 'EnrollmentController@delete', checkRole('admin'));
$router->post('/enrollments/student',  'EnrollmentController@student');

// grades
$router->get('/grades', 'GradeController@index');
$router->get('/grades/create', 'GradeController@create');
$router->post('/grades/store', 'GradeController@store');
$router->get('/grades/edit/{id}', 'GradeController@edit');
$router->post('/grades/update/{id}', 'GradeController@update');
$router->get('/grades/delete/{id}', 'GradeController@delete', checkRole('admin'));
$router->post('/grades/course', 'GradeController@course');

// reports
$router->get('/reports', 'ReportController@index');
$router->get('/reports/create', 'ReportController@create');
$router->post('/reports/store', 'ReportController@store');
$router->get('/reports/edit/{id}', 'ReportController@edit');
$router->post('/reports/update/{id}', 'ReportController@update');
$router->get('/reports/delete/{id}', 'ReportController@delete', checkRole('admin'));

// grade change requests
$router->get('/grade-change-requests', 'GradeChangeRequestController@index');
$router->get('/grade-change-requests/create', 'GradeChangeRequestController@create');
$router->post('/grade-change-requests/store', 'GradeChangeRequestController@store');
$router->get('/grade-change-requests/edit/{id}', 'GradeChangeRequestController@edit');
$router->post('/grade-change-requests/update/{id}', 'GradeChangeRequestController@update');
$router->get('/grade-change-requests/delete/{id}', 'GradeChangeRequestController@delete', checkRole('admin'));


// notifications
$router->get('/notifications', 'NotificationController@index');
$router->get('/notifications/create', 'NotificationController@create');
$router->post('/notifications/store', 'NotificationController@store');
$router->get('/notifications/edit/{id}', 'NotificationController@edit');
$router->post('/notifications/update/{id}', 'NotificationController@update');
$router->get('/notifications/delete/{id}', 'NotificationController@delete', checkRole('admin'));

$router->resolve();