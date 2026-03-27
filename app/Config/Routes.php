<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Students::index');

$routes->get('/students', 'Students::index');
$routes->get('/students/(:alpha)', 'Students::studentForm/$1');