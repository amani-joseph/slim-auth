<?php

use App\Middleware\CorsMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(CorsMiddleware::class);
    $app->addRoutingMiddleware();
};
