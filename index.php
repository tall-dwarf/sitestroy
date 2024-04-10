<?php
require __DIR__ . "/vendor/autoload.php";

use MiladRahimi\PhpRouter\Router;
use Laminas\Diactoros\Response\JsonResponse;
use MiladRahimi\PhpRouter\View\View;
use SiteStroy\Controllers\UserController;
use SiteStroy\Controllers\ProfileController;
use SiteStroy\Middleware\AuthMiddleware;
use SiteStroy\Controllers\ToDoListController;
use SiteStroy\Middleware\AdminMiddleware;
use SiteStroy\Controllers\AdminController;

$router = Router::create();
$router->setupView(__DIR__ . '/views');

$router->get('/404', function () {
    return "база, фундамент, грунт.";
});

$router->get('/', function (View $view) {
    return $view->make('main');
});


$router->post('/user/login', [UserController::class, 'login']);
$router->get('/user/login', [UserController::class, 'loginPage']);

$router->get('/user/register', [UserController::class, 'registerPage']);
$router->post('/user/register', [UserController::class, 'register']);


$router->group(['middleware' => [AuthMiddleware::class]], function(Router $router) {
    $router->patch('/to-do-list', [ToDoListController::class, 'toggle']);
    $router->post('/to-do-list', [ToDoListController::class, 'create']);
    $router->delete('/to-do-list', [ToDoListController::class, 'delete']);

    $router->get('/profile', [ProfileController::class, 'profilePage']);
});



$router->group(['middleware' => [AuthMiddleware::class, AdminMiddleware::class]], function(Router $router) {
    $router->patch('/admin/to-do-list', [AdminController::class, 'changeTodo']);
    $router->post('/admin/to-do-list', [AdminController::class, 'createTodo']);
    $router->delete('/admin/to-do-list', [AdminController::class, 'deleteTodo']);

    $router->get('/admin', [AdminController::class, 'index']);
});

$router->dispatch();