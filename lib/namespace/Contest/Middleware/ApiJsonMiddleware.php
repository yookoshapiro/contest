<?php

declare(strict_types=1);

namespace Contest\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ApiJsonMiddleware
{

    /**
     * Stellt sicher, dass Inhaltstyp der Rückgabe immer vom Type json ist.
     *
     * @param Request        $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ApiException
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        return $handler
            ->handle($request)
            ->withHeader('Content-Type', 'application/json');

    }

}