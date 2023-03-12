<?php

declare(strict_types=1);

namespace Contest\Middleware\Api;

use Contest\Exception\ApiException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ExceptionMiddleware
{

    /**
     * Kapselt die Exception eine ApiException, damit wir damit eine bessere Fehlerausgabe erzeugen können.
     *
     * @param Request        $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ApiException
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        try {
            return $handler->handle($request);
        }

        catch (\Exception $ex) {
            throw ApiException::createFromException($ex);
        }

    }

}