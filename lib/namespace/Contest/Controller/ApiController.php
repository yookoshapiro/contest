<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Api\ApiStatus;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Contest\Contract\Config\ConfigInterface as Config;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ApiController
{

    /**
     * Erzeugt diese Klasse.
     *
     * @param Config $config
     */
    public function __construct(
        public readonly Config $config
    ) {}


    /**
     * Antwort auf 'api'.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {

        $payload = json_encode(['data' => ['message' => 'Welcome to the Feuerwehr Dechow Contest API.']]);
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

        if ($this->config->get('status.state') !== ApiStatus::OK)
        {

            $response->getBody()->write(json_encode([
                'data' => [
                    'status' => $this->config->get('status.state'),
                    'message' => $this->config->get('status.message')
                ]
            ]));

            return $response
                ->withStatus(503);

        }

        $response->getBody()->write(json_encode([
            'data' => [
                'status' => ApiStatus::OK
            ]
        ]));

        return $response;

    }


    /**
     * Wird aufgerufen, wenn keine der anderen Routen einen Treffer landete.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function unknown(Request $request, Response $response): Response
    {

        $response->getBody()->write(json_encode([
            'error' => 'route not found'
        ]));

        return $response
            ->withStatus(404);

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
        $group->get('/status', [self::class, 'status']);

        $group->group('/auth', [AuthController::class, 'router']);

        $group->group('/team', [TeamController::class, 'router']);
        $group->group('/teams', [TeamsController::class, 'router']);

        $group->group('/user', [UserController::class, 'router']);
        $group->group('/users', [UsersController::class, 'router']);

        $group->group('/station', [StationController::class, 'router']);
        $group->group('/stations', [StationsController::class, 'router']);

        $group->group('/result', [ResultController::class, 'router']);
        $group->group('/results', [ResultsController::class, 'router']);

        $group->get('/{path:.*}', [self::class, 'unknown']);

    }

}