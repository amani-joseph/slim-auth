<?php
use DI\Container;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return function (Container $container)
{
    $defaultDB = data_get(config('database.connections'), config('database.default'));

    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($defaultDB);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};
