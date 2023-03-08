<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Api\ApiStatus;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ApiController extends AbstractController
{

    /**
     * Antwort auf 'api'.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {
        $payload = json_encode(['message' => 'Welcome to the Feuerwehr Dechow Contest API.']);
        $response->getBody()->write($payload);

        return $response;

    }


    /**
     * Gibt den Status der API wieder.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function status(Request $request, Response $response): Response
    {

        $payload = json_encode(['status' => ApiStatus::OK]);
        $response->getBody()->write($payload);

        return $response;

    }


    /**
     * Routen für die Route '/api'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->get('', [self::class, 'show']);
        $group->get('/', [self::class, 'show']);
        $group->get('/status', [self::class, 'status']);

        $group->group('/auth', [AuthController::class, 'router']);
        $group->group('/team', [TeamController::class, 'router']);
        $group->group('/user', [UserController::class, 'router']);
        $group->group('/users', [UsersController::class, 'router']);

    }

}