<?php
// ============================================================
// FRONT CONTROLLER — All requests pass through here.
// This is the single entry point for the application.
// ============================================================

session_start();

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/core/helpers.php';
require_once dirname(__DIR__) . '/core/Router.php';

foreach (glob(dirname(__DIR__) . '/app/models/*.php') as $model) {
    require_once $model;
}

foreach (glob(dirname(__DIR__) . '/app/controllers/*.php') as $controller) {
    require_once $controller;
}

$router = new Router();

// --- Public routes ---
$router->add('',                          ['HomeController',      'index']);
$router->add('posts',                     ['PostController',      'publicList']);
$router->add('posts/view/{slug}',         ['PostController',      'view']);
$router->add('posts/category/{slug}',     ['PostController',      'byCategory']);
$router->add('search',                    ['PostController',      'search']);

// --- Auth routes ---
$router->add('auth/register',             ['AuthController',      'register']);
$router->add('auth/login',                ['AuthController',      'login']);
$router->add('auth/logout',               ['AuthController',      'logout']);

// --- Dashboard ---
$router->add('dashboard',                 ['DashboardController', 'index']);

// --- Post management ---
$router->add('dashboard/posts',                 ['PostController', 'dashboardList']);
$router->add('dashboard/posts/create',          ['PostController', 'create']);
$router->add('dashboard/posts/edit/{id}',       ['PostController', 'edit']);
$router->add('dashboard/posts/delete/{id}',     ['PostController', 'delete']);
$router->add('dashboard/posts/approve/{id}',    ['PostController', 'approve']);
$router->add('dashboard/posts/reject/{id}',     ['PostController', 'reject']);

// --- Category management ---
$router->add('dashboard/categories',              ['CategoryController', 'index']);
$router->add('dashboard/categories/create',       ['CategoryController', 'create']);
$router->add('dashboard/categories/edit/{id}',    ['CategoryController', 'edit']);
$router->add('dashboard/categories/delete/{id}',  ['CategoryController', 'delete']);

// --- User management ---
$router->add('dashboard/users',                ['UserController', 'index']);
$router->add('dashboard/users/edit/{id}',      ['UserController', 'edit']);
$router->add('dashboard/users/delete/{id}',    ['UserController', 'delete']);
$router->add('dashboard/users/create', ['UserController', 'createUser']);
// --- Comments ---
$router->add('comments/store',               ['CommentController', 'store']);

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {

    $basePath = '/mini_pro_rideally_v2/public';

} else {

    $basePath = '/public';

}

$url = trim(str_replace($basePath, '', $requestUri), '/');

/*
|--------------------------------------------------------------------------
| Remove index.php if present
|--------------------------------------------------------------------------
*/
if (strpos($url, 'index.php') === 0) {
    $url = trim(substr($url, strlen('index.php')), '/');
}

$router->dispatch($url);