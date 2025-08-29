<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/artikel', 'Artikel::index');
$routes->get('artikel/detaill/(:num)', 'Artikel::detaill/$1'); // pindahkan ke atas
$routes->get('artikel/detail/(:num)', 'Artikel::detail/$1');   // juga pindahkan ini ke atas
$routes->get('/artikel/(:any)', 'Artikel::view/$1');           // letakkan paling bawah
$routes->get('user/login', 'User::login');
$routes->post('user/login', 'User::login');
$routes->get('admin/artikel', 'Artikel::admin_index');
$routes->get('admin/artikel/add', 'Artikel::formAdd');
$routes->post('admin/artikel/add', 'Artikel::saveAdd');
$routes->get('admin/artikel/edit/(:num)', 'Artikel::formEdit/$1');
$routes->post('admin/artikel/edit/(:num)', 'Artikel::saveEdit/$1');
$routes->get('admin/artikel/delete/(:num)', 'Artikel::delete/$1');
$routes->get('artikel/(:segment)', 'Artikel::view/$1');
$routes->get('ajax', 'AjaxController::index');
$routes->get('ajax/getData', 'AjaxController::getData');
$routes->post('ajax/create', 'AjaxController::create');
$routes->post('ajax/update/(:num)', 'AjaxController::update/$1');
$routes->delete('ajax/delete/(:num)', 'AjaxController::delete/$1');
$routes->get('admin/artikel/detail/(:num)', 'Artikel::detail/$1');




$routes->resource('post');

$routes->setAutoRoute(true);

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});
