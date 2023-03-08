<?php

declare(strict_types=1);

namespace Contest\Controller;

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UsersController extends AbstractController
{

    /**
     *
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response): Response
    {

        $response->getBody()->write(json_encode([
            [
                'id' => '458cbcfd39ed4fee03dd442c6e2ad4f9'
            ]
        ]));

        return $response;

    }


    /**
     * Routen für die Route '/api/users'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->get('', [self::class, 'list']);

    }

}