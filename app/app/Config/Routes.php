<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('about', 'Page::about');
$routes->get('contact', 'Page::contact');

$routes->get('artikel', 'Artikel::index');
$routes->get('artikel/(:segment)', 'Artikel::view/$1');

$routes->group('user', static function ($routes): void {
    $routes->match(['get', 'post'], 'login', 'User::login');
    $routes->get('logout', 'User::logout');
});

$routes->post('api/login', 'Api\Auth::login');
$routes->get('api/artikel', 'Api\Artikel::index');
$routes->post('api/artikel', 'Api\Artikel::create', ['filter' => 'apiauth']);
$routes->put('api/artikel/(:segment)', 'Api\Artikel::update/$1', ['filter' => 'apiauth']);
$routes->delete('api/artikel/(:segment)', 'Api\Artikel::delete/$1', ['filter' => 'apiauth']);

$routes->group('admin', ['filter' => 'auth'], static function ($routes): void {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->match(['get', 'post'], 'artikel/add', 'Artikel::add');
    $routes->match(['get', 'post'], 'artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');

    $routes->get('kategori', 'Kategori::index');
    $routes->match(['get', 'post'], 'kategori/add', 'Kategori::add');
    $routes->match(['get', 'post'], 'kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');
});
