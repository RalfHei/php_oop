<?php

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\AdminController;
use app\controllers\BlogController;
use app\controllers\PostsController;
use app\controllers\UserController;
use app\core\Application;
use app\core\lang\En_en;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/admin', [AdminController::class, 'admin']);
$app->router->post('/edit', [AdminController::class, 'edit']);
$app->router->get("/edit", [UserController::class, 'userEdit']);
$app->router->post("/update", [UserController::class, 'userUpdate']);
$app->router->get("/delete", [UserController::class, 'destroy']);


$app->router->get("/", [SiteController::class, 'blog']);
$app->router->get("/search", [SiteController::class, 'search']);
$app->router->get("/blogpost", [SiteController::class, 'blogPost']);


$app->router->post('/newpost', [BlogController::class, 'newPost']);
$app->router->get("/newpost", [BlogController::class, 'newPost']);
$app->router->post('/updatepost', [BlogController::class, 'update']);
$app->router->get("/editpost", [BlogController::class, 'edit']);
$app->router->get("/deletepost", [BlogController::class, 'destroy']);
$app->router->get("/blogpost/img", [SiteController::class, 'image']);
$app->router->post("/images", [SiteController::class, 'images']);
$app->router->get("/posts", [PostsController::class, 'posts']);




$app->run();
