<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/guide', 'Guide::index');
$routes->get('/about', 'About::index');
$routes->get('/destinations', 'Destination::index');
$routes->get('/login', 'Auth::loginPage');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::registerPage');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('search', 'Search::index');
    $routes->get('search/destination', 'Search::byDestination');
    $routes->get('search/category', 'Search::byCategory');
    $routes->get('categories', 'Category::index');
    $routes->get('bus/(:num)', 'Bus::detail/$1');
});

$routes->group('user', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'User::dashboard');
    $routes->get('profile', 'User::profile');
    $routes->post('profile/update', 'User::updateProfile');
    $routes->post('password/update', 'User::updatePassword');
});

$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\\Dashboard::index');

    // Destination CRUD
    $routes->get('destination', 'Admin\\Destination::index');
    $routes->get('destination/create', 'Admin\\Destination::create');
    $routes->post('destination/store', 'Admin\\Destination::store');
    $routes->get('destination/edit/(:num)', 'Admin\\Destination::edit/$1');
    $routes->post('destination/update/(:num)', 'Admin\\Destination::update/$1');
    $routes->get('destination/delete/(:num)', 'Admin\\Destination::delete/$1');

    // Bus CRUD
    $routes->get('bus', 'Admin\\Bus::index');
    $routes->get('bus/create', 'Admin\\Bus::create');
    $routes->post('bus/store', 'Admin\\Bus::store');
    $routes->get('bus/edit/(:num)', 'Admin\\Bus::edit/$1');
    $routes->post('bus/update/(:num)', 'Admin\\Bus::update/$1');
    $routes->get('bus/delete/(:num)', 'Admin\\Bus::delete/$1');

    // User Management
    $routes->get('users', 'Admin\\User::index');
    $routes->get('users/create', 'Admin\\User::create');
    $routes->post('users/store', 'Admin\\User::store');
    $routes->get('users/edit/(:num)', 'Admin\\User::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\\User::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\\User::delete/$1');

    // Activity Logs
    $routes->get('logs', 'Admin\\ActivityLog::index');

    // Homepage image settings
    $routes->get('settings/homepage', 'Admin\\Settings::index');
    $routes->post('settings/homepage', 'Admin\\Settings::update');
    $routes->get('settings/delete/(:segment)', 'Admin\\Settings::delete/$1');
});
