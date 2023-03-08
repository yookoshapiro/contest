<?php

declare(strict_types=1);

namespace Contest\Controller;

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

final class AuthController extends AbstractController
{


    /**
     * Verarbeitet eine Login-Anfrage.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @return ResponseInterface
     */
    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        return $response;

    }


    /**
     * Router für die Route '/api/auth'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->post('login', [self::class, 'login']);

    }


}