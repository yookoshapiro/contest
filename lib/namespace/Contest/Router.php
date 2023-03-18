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

        $group->group('/api', [Controller\ApiController::class, 'router'])
            ->add(Api\ExceptionMiddleware::class)
            ->add(Api\JsonMiddleware::class);

        $group->any('{path:.*}', Controller\HomeController::class);

    }

}