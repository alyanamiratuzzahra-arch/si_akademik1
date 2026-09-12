<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Core/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Core\Router;

$router = new Router();
$routes = require __DIR__ . '/../routes/web.php';

foreach ($routes as $key => $handler) {
    [$method, $path] = explode(' ', $key, 2);
    $router->add($method, $path, $handler);
}

$router->dispatch();
