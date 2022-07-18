<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'UserController::index');

$routes->get('/users', 'UserController::index', ['as' => 'users']);
$routes->get('/users/detail/(:num)', 'UserController::show/$1', ['as' => 'user_show']);
$routes->get('/users/reset-password/(:num)', 'UserController::resetPasswd/$1', ['as' => 'user_reset_passwd']);
$routes->put('/users/reset-password/(:num)', 'UserController::updatePasswd/$1', ['as' => 'user_reset_passwd']);

$routes->get('/users/add', 'UserController::create', ['as' => 'user_add']);
$routes->post('/users/add', 'UserController::store', ['as' => 'user_add']);
$routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['as' => 'user_edit']);
$routes->put('/users/edit/(:num)', 'UserController::update/$1', ['as' => 'user_edit']);
$routes->get('/users/del', 'UserController::delete', ['as' => 'user_delete']);

$routes->get('/users/check/add/(:num)', 'UserController::createUserCheck/$1', ['as' => 'user_check_add']);
$routes->post('/users/check/add/(:num)', 'UserController::storeUserCheck/$1', ['as' => 'user_check_add']);
$routes->put('/users/check/edit', 'UserController::updateUserCheck', ['as' => 'user_check_edit']);
$routes->get('/users/check/del', 'UserController::deleteUserCheck', ['as' => 'user_check_delete']);

$routes->get('/users/reply/add/(:num)', 'UserController::createUserReply/$1', ['as' => 'user_reply_add']);
$routes->post('/users/reply/add/(:num)', 'UserController::storeUserReply/$1', ['as' => 'user_reply_add']);
$routes->put('/users/reply/edit', 'UserController::updateUserReply', ['as' => 'user_reply_edit']);
$routes->get('/users/reply/del', 'UserController::deleteUserReply', ['as' => 'user_reply_delete']);

###############################################################################

$routes->get('/groups', 'GroupController::index', ['as' => 'groups']);
$routes->get('/groups/detail/(:num)', 'GroupController::show/$1', ['as' => 'group_show']);

$routes->get('/groups/add', 'GroupController::create', ['as' => 'group_add']);
$routes->post('/groups/add', 'GroupController::store', ['as' => 'group_add']);
$routes->get('/groups/edit/(:num)', 'GroupController::edit/$1', ['as' => 'group_edit']);
$routes->put('/groups/edit/(:num)', 'GroupController::update/$1', ['as' => 'group_edit']);
$routes->get('/groups/del', 'GroupController::delete', ['as' => 'group_delete']);

$routes->get('/groups/check/add/(:num)', 'GroupController::createGroupCheck/$1', ['as' => 'group_check_add']);
$routes->post('/groups/check/add/(:num)', 'GroupController::storeGroupCheck/$1', ['as' => 'group_check_add']);
$routes->put('/groups/check/edit', 'GroupController::updateGroupCheck', ['as' => 'group_check_edit']);
$routes->get('/groups/check/del', 'GroupController::deleteGroupCheck', ['as' => 'group_check_delete']);

$routes->get('/groups/reply/add/(:num)', 'GroupController::createGroupReply/$1', ['as' => 'group_reply_add']);
$routes->post('/groups/reply/add/(:num)', 'GroupController::storeGroupReply/$1', ['as' => 'group_reply_add']);
$routes->put('/groups/reply/edit', 'GroupController::updateGroupReply', ['as' => 'group_reply_edit']);
$routes->get('/groups/reply/del', 'GroupController::deleteGroupReply', ['as' => 'group_reply_delete']);

###############################################################################

$routes->get('/nases', 'NasController::index', ['as' => 'nases']);
$routes->get('/nases/add', 'NasController::create', ['as' => 'nas_add']);
$routes->post('/nases/add', 'NasController::store', ['as' => 'nas_add']);
$routes->get('/nases/edit/(:num)', 'NasController::edit/$1', ['as' => 'nas_edit']);
$routes->put('/nases/edit/(:num)', 'NasController::update/$1', ['as' => 'nas_edit']);
$routes->get('/nases/del', 'NasController::delete', ['as' => 'nas_delete']);

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
