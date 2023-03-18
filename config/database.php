<?php

use Illuminate\Support\Str;

return [
    'default' => env('DEFAULT_DB_CONNECTION', 'default_mysql'),


    'connections' => [
        'default_mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DEFAULT_DB_HOST', '127.0.0.1'),
            'port' => env('DEFAULT_DB_PORT', '3306'),
            'database' => env('DEFAULT_DB_DATABASE', 'poc_backend'),
            'username' => env('DEFAULT_DB_USERNAME', 'root'),
            'password' => env('DEFAULT_DB_PASSWORD', 'Chancery@1'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
    ]


];