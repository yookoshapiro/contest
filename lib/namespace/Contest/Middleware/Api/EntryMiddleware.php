<?php

declare(strict_types=1);

namespace Contest\Middleware\Api;

use Contest\Exception\EntryMiddlewareException;
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


    protected static function findModel(Request $request, RequestHandler $handler, string $class, string $name, mixed $id): Response
    {

        try
        {

            $model = call_user_func([$class, 'find'], $id);

            if ($model === null) {
                throw new EntryMiddlewareException;
            }

            return $handler->handle(
                $request->withAttribute($name, $model)
            );

        }
        catch (EntryMiddlewareException $ex)
        {

            $response = new \Slim\Psr7\Response;

            $response->getBody()->write(json_encode([
                'error' => "no {$name} with id '{$id}' found"
            ]));

            return $response
                ->withStatus(404);

        }

    }


    /**
     * Setzt den aktuellen Benutzer als Attribut in das Request-Objekt.
     *
     * @param string $class
     * @param string $attributeName
     * @return callable
     */
    public static function fromQuery(string $class, string $attributeName = 'id'): callable
    {

        return function(Request $request, RequestHandler $handler) use ($class, $attributeName): Response
        {

            $routeContext = RouteContext::fromRequest($request);
            $route = $routeContext->getRoute();

            $id = $route->getArgument($attributeName);
            $name = self::extractName($class);

            return self::findModel($request, $handler, $class, $name, $id);

        };

    }


    /**
     * Liest das Attribut aus dem Body aus.
     *
     * @param string $class
     * @param string $attributeName
     * @return callable
     */
    public static function fromBody(string $class, string $attributeName): callable
    {

        return function(Request $request, RequestHandler $handler) use ($class, $attributeName): Response
        {

            $post = $request->getParsedBody();
            $name = self::extractName($class);

            return self::findModel($request, $handler, $class, $name, $post[ $attributeName ]);

        };

    }

}