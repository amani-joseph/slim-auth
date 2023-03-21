<?php

use App\Controllers\Authentication\RegisterController;
use App\Controllers\Authentication\LoginController;
use App\Controllers\Authentication\PasswordController;
use App\Controllers\Users\UsersController;
use App\Middleware\JsonBodyParserMiddleware;
use Slim\App;
use Slim\Middleware\BodyParsingMiddleware;

return function (App $app) {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->group("/api/v1", function ($app) {
        $app->group("/auth", function ($app) {
            $app->post('/register', [RegisterController::class, 'register']);
            $app->post('/login', [LoginController::class, 'login']);
            $app->post('/passwordForgot', [PasswordController::class, 'passwordForgot']);
            $app->post('/passwordReset', [PasswordController::class, 'passwordReset']);
            $app->post('/passwordChange', [PasswordController::class, 'passwordChange']);
        })->add(JsonBodyParserMiddleware::class);
        $app->group("/users", function ($app) {
            $app->get('/all', [UsersController::class, 'all']);
            $app->get("/user/{id}", [UsersController::class, 'user']);
        })->add(JsonBodyParserMiddleware::class);
    });

};