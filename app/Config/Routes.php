<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers\Web');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Errors');
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
 * --------------------------------------------------------------------
 * WEB Endpoints
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Login::index', ['filter' => 'no-auth']);
$routes->get('dashboard', 'Dashboard::index');
$routes->get('accounts', 'Accounts::index');
$routes->get('transactions', 'Transactions::index');
$routes->get('test', 'Test::index');

/*
 * --------------------------------------------------------------------
 * API Endpoints
 * --------------------------------------------------------------------
 */

 $routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes){
	$routes->group('auth', function ($routes) {
		$routes->post('signup', 'Auth::signup');
		$routes->post('login', 'Auth::login');
	});

	$routes->group('me', ['namespace' => 'App\Controllers\Api', 'filter' => 'api'], function ($routes) {
		$routes->get('/', 'Users::profile');
		$routes->get('logout', 'Auth::logout');
	});

	$routes->group('accounts', ['namespace' => 'App\Controllers\Api', 'filter' => 'api'], function ($routes) {
		$routes->get('/', 'Accounts::index');
		$routes->get('delete/(:num)', 'Accounts::delete/$1');
		$routes->get('edit/(:num)', 'Accounts::edit/$1');
		$routes->post('/', 'Accounts::create');
		$routes->post('update/(:num)', 'Accounts::update/$1');
		$routes->group('type', function ($routes) {
			$routes->get('/', 'Nature::index');
			$routes->get('delete/(:num)', 'Nature::delete/$1');
			$routes->get('edit/(:num)', 'Nature::edit/$1');
		});
	});

	$routes->group('transactions', ['namespace' => 'App\Controllers\Api', 'filter' => 'api'], function ($routes) {
		$routes->get('/', 'Transactions::index');
		$routes->get('delete/(:num)', 'Transactions::delete/$1');
		$routes->get('edit/(:num)', 'Transactions::edit/$1');
		$routes->post('/', 'Transactions::create');
		$routes->post('update/(:num)', 'Transactions::update/$1');
		$routes->group('operators', function ($routes) {
			$routes->get('/', 'Operator::index');
			$routes->get('delete/(:num)', 'Operator::delete/$1');
			$routes->get('edit/(:num)', 'Operator::edit/$1');
		});
	});


 });

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
