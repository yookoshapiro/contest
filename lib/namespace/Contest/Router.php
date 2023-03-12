<?php

declare(strict_types=1);

namespace Contest;

use Contest\Middleware\Api;
use Slim\Routing\RouteCollectorProxy;

class Router
{

    /**
     * Router für die Route '/'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public function __invoke(RouteCollectorProxy $group): void
    {

        $group->get('/', Controller\HomeController::class);
        $group->group('/api', [Controller\ApiController::class, 'router'])
            ->add(Api\ExceptionMiddleware::class)
            ->add(Api\JsonMiddleware::class);

    }

}