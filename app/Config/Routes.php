<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::index');

//students
$routes->group('students', function($routes){
    $routes->get('/', 'Students::index', ['filter' => 'auth']);
    $routes->post('counter', 'Students::getLatestCounter', ['filter' => 'auth']);
    $routes->post('add', 'Students::add', ['filter' => 'auth']);
    $routes->post('edit', 'Students::edit', ['filter' => 'auth']);
    $routes->post('delete', 'Students::delete', ['filter' => 'auth']);
    $routes->post('search', 'Students::searchStudent', ['filter' => 'auth']);
    $routes->get('(:segment)', 'Students::studentForm/$1', ['filter' => 'auth']);
});

$routes->get('login', 'Admin::index', ['filter' => 'noauth']);
$routes->post('login', 'Admin::login', ['filter' => 'noauth']);
$routes->get('register', 'Admin::registerForm', ['filter' => 'noauth']);
$routes->post('register', 'Admin::registerUser', ['filter' => 'noauth']);
$routes->get('logout', 'Admin::logout');
$routes->group('admin', function($routes){
    $routes->get('profile', 'Admin::profile', ['filter' => 'auth']);
    $routes->post('edit', 'Admin::edit', ['filter' => 'auth']);
});

$routes->group('majors', function($routes){
    $routes->get('/', 'Majors::index', ['filter' => 'auth']);
    $routes->post('add', 'Majors::add', ['filter' => 'auth']);
    $routes->post('edit', 'Majors::edit', ['filter' => 'auth']);
    $routes->post('delete', 'Majors::delete', ['filter' => 'auth']);
    $routes->post('search', 'Majors::searchMajor', ['filter' => 'auth']);
    $routes->get('(:segment)', 'Majors::majorForm/$1', ['filter' => 'auth']);
});
