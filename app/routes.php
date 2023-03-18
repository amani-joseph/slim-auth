<?php

use App\Controllers\Authentication\RegisterController;
use App\Controllers\Authentication\LoginController;
use App\Controllers\Authentication\PasswordController;
use App\Controllers\Users\UsersController;
use Slim\App;

return function (App $app) {
    $app->group("/api/v1", function ($app) {
        $app->group("/auth", function ($app) {
            $app->post('/register', [RegisterController::class, 'register']);
            $app->post('/login', [LoginController::class, 'login']);
            $app->post('/passwordForgot', [PasswordController::class, 'passwordForgot']);
            $app->post('/passwordReset', [PasswordController::class, 'passwordReset']);
            $app->post('/passwordChange', [PasswordController::class, 'passwordChange']);
        });
        $app->group("/users", function ($app) {
            $app->get('/all', [UsersController::class, 'all']);
            $app->get("/user/{id}", [UsersController::class, 'user']);
        });
    });

};