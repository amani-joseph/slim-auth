<?php
require __DIR__ .'/../vendor/autoload.php';

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

//set container on the app
$container = new Container();
$app = SlimAppFactory::create($container);

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$connection = require __DIR__ . '/../app/connection.php';
$connection($container);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();