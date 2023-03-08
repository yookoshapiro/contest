<?php

declare(strict_types=1);

return [

    Dotenv\Dotenv::class => DI\factory(function() {
        return Dotenv\Dotenv::createImmutable( root_path() );
    }),

    Contest\Contract\Config\ConfigInterface::class => DI\get(Contest\Config::class)

];
