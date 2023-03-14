<?php

declare(strict_types=1);

namespace Contest\Middleware\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;

class EntryMiddleware
{

    /**
     * Gibt den Namen der Klasse wieder.
     *
     * @param string $class
     * @return string
     */
    protected static function extractName(string $class): string
    {

        if ( ! class_exists($class)) {
            throw new \BadMethodCallException("unknown class '{$class}'");
        }

        if ($pos = strrpos($class, '\\')) {
            return strtolower(substr($class, $pos + 1));
        }

        return strtolower($class);

    }


    /**
     * Setzt den aktuellen Benutzer als Attribut in das Request-Objekt.
     *
     * @param string $class
     * @param string $attributeName
     * @return callable
     */
    public static function factory(string $class, string $attributeName = 'id'): callable
    {

        return function(Request $request, RequestHandler $handler) use ($class, $attributeName): Response
        {

            $routeContext = RouteContext::fromRequest($request);
            $route = $routeContext->getRoute();

            $id = $route->getArgument($attributeName);
            $name = self::extractName($class);

            try
            {

                return $handler->handle(
                    $request->withAttribute($name, call_user_func([$class, 'findOrFail'], $id))
                );

            }
            catch (\Exception $ex)
            {

                $response = new \Slim\Psr7\Response;

                $response->getBody()->write(json_encode([
                    'error' => "no {$name} with id '{$id}' found"
                ]));

                return $response
                    ->withStatus(404);

            }

        };

    }

}