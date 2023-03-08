<?php

declare(strict_types=1);

namespace Contest;

use Slim\Routing\RouteCollectorProxy;
use Contest\Middleware\{ApiJsonMiddleware, ApiExceptionMiddleware};

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

        $group->get('/', [Controller\HomeController::class, 'router']);
        $group->group('/api', [Controller\ApiController::class, 'router'])
            ->add(ApiExceptionMiddleware::class)
            ->add(ApiJsonMiddleware::class);

    }

}