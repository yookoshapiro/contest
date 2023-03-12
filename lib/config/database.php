<?php

declare(strict_types=1);

return [

    'connection' => [
        'driver' => 'mysql',
        'host' => $_ENV['MYSQL_HOST'],
        'database' => $_ENV['MYSQL_DATABASE'],
        'username' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]

];