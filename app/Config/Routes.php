<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::index');

//students
$routes->group('students', function($routes){
    $routes->get('/', 'Students::index');
    $routes->post('counter', 'Students::getLatestCounter');
    $routes->post('add', 'Students::add');
    $routes->post('edit', 'Students::edit');
    $routes->post('delete', 'Students::delete');
    $routes->post('search', 'Students::searchStudent');
    $routes->get('(:segment)', 'Students::studentForm/$1');
});

$routes->get('login', 'Admin::index');
$routes->post('login', 'Admin::login');
$routes->get('register', 'Admin::registerForm');
$routes->post('register', 'Admin::registerUser');
$routes->get('logout', 'Admin::logout');
