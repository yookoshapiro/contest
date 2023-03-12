<?php

declare(strict_types=1);

namespace Contest\Middleware\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonMiddleware
{

    /**
     * Stellt sicher, dass Inhaltstyp der Rückgabe immer vom Type json ist.
     *
     * @param Request        $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        return $handler
            ->handle($request)
            ->withHeader('Content-Type', 'application/json');

    }

}