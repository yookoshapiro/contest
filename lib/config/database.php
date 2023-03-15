<?php

declare(strict_types=1);

return [

    'connection' => [
        'driver' => 'mysql',
        'host' => (isset($_ENV['SHELL_ACTIVE']) and $_ENV['SHELL_ACTIVE'] === true)  ? $_ENV['MYSQL_CONSOLE_HOST'] : $_ENV['MYSQL_HOST'],
        'database' => $_ENV['MYSQL_DATABASE'],
        'username' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]

];