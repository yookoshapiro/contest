<?php

declare(strict_types=1);

namespace Contest\Controller;

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

final class TeamController
{


    /**
     * Gibt einen Benutzer wieder,
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $args
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        return $response;

    }


    /**
     * Router für die Route '/api/team'
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->get('/{id}', [self::class, 'show']);

    }

}