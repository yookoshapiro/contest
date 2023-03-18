<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface as Container;
use Contest\Contract\Config\ConfigInterface as Config;

return [

    Dotenv\Dotenv::class => DI\factory(function() {
        return Dotenv\Dotenv::createImmutable( root_path() );
    }),

    Config::class => DI\create(Contest\Configuration\Manager::class)
        ->constructor( root_path('lib/config/'), DI\get(Dotenv\Dotenv::class) ),

    Illuminate\Database\Capsule\Manager::class => DI\factory(function(Container $container, Config $config)
    {

        $manager = new Illuminate\Database\Capsule\Manager;

        $manager->setEventDispatcher( $container->get(Illuminate\Events\Dispatcher::class) );
        $manager->addConnection( $config->get('database.connection') );
        $manager->bootEloquent();

        return $manager;

    }),

    Illuminate\Database\Connection::class => DI\factory(function(Illuminate\Database\Capsule\Manager $manager) {
        return $manager->getConnection();
    }),

    Slim\Views\Twig::class => DI\factory(function()  {
        return Slim\Views\Twig::create(root_path('lib/views'), [
            'cache' => false
        ]);
    }),

    Slim\Views\TwigMiddleware::class => DI\factory(function(Slim\App $app, Slim\Views\Twig $twig) {
        return Slim\Views\TwigMiddleware::create($app, $twig);
    })

];
