<?php

declare(strict_types=1);

namespace Contest\Controller;

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UserController extends AbstractController
{

    /**
     * Zeigt einen Benutzer an.
     *
     * @param Request $request
     * @param Response $response
     * @param array $attr
     * @return Response
     */
    public function show(Request $request, Response $response, array $attr): Response
    {

        $payload = json_encode([
            'id' => $attr['id'],
            'name' => 'Yooko Shapiro'
        ]);
        $response->getBody()->write($payload);

        return $response;

    }


    /**
     * Erzeugt einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {

        $response->getBody()->write(json_encode([
            'id' => md5( (string) time() ),
            'create' => true
        ]));

        return $response
            ->withStatus(201);

    }


    /**
     * Bearbeitet einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {

        return $response
            ->withStatus(204);

    }


    /**
     * Entfernt einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route '/api/user'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->post('', [self::class, 'create']);
        $group->get('/{id}', [self::class, 'show']);
        $group->patch('/{id}', [self::class, 'edit']);
        $group->delete('/{id}', [self::class, 'remove']);

    }

}