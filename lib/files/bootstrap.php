<?php

declare(strict_types=1);

use Contest\Container;
use DI\ContainerBuilder;
use Illuminate\Database\Connection;
use Psr\Container\ContainerInterface;

$builder = new ContainerBuilder(Container::class);
$builder->addDefinitions( root_path('lib/files/di.definitions.php') );

$container = $builder->build();

$container->set(ContainerInterface::class, $container);
$container->get(Connection::class); # Aufruf der Verbindung, damit die Einstellungen geladen werden

return $container;