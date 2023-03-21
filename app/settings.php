<?php

use Monolog\Logger;
use Psr\Container\ContainerInterface;

return function (ContainerInterface $container)
{
    $container->set('settings', function ()
    {
        return [
            "displayErrorDetails"=>true,
            "logErrors"=>true,
            "logErrorDetails"=>true,
            'logger' => [
                'name' => 'slim-app',
                'path' => !empty(env('DOCKER')) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
        ];
    });
};