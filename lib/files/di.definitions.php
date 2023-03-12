<?php

declare(strict_types=1);

use Contest\Contract\Config\ConfigInterface as Config;

return [

    Dotenv\Dotenv::class => DI\factory(function() {
        return Dotenv\Dotenv::createImmutable( root_path() );
    }),

    Config::class => DI\create(Contest\Configuration\Manager::class)
        ->constructor( root_path('lib/config/'), DI\get(Dotenv\Dotenv::class) ),

    Illuminate\Database\Connection::class => DI\factory(function(Config $config)
    {

        $manager = new Illuminate\Database\Capsule\Manager;

        $manager->addConnection( $config->get('database.connection') );
        $manager->bootEloquent();

        return $manager->getConnection();

    })

];
