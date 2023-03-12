<?php

declare(strict_types=1);

namespace Contest\Middleware\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

abstract class ValidationMiddleware
{

    /**
     * Gibt die Middleware zur Validierung beim Erzeugen von Inhalten wieder.
     *
     * @param callable|array $validation
     * @return callable
     */
    public static function forCreating(callable|array $validation): callable {
        return self::getMiddleware($validation, true);
    }


    /**
     * Gibt die Middleware zur Validierung beim Aktualisieren von Inhalten wieder.
     *
     * @param callable|array $validation
     * @return callable
     */
    public static function forUpdating(callable|array $validation): callable {
        return self::getMiddleware($validation);
    }


    /**
     * Gibt eine Middleware zum Validieren der Benutzereingaben wieder.
     *
     * @param callable|array $validation
     * @param bool           $newRecord
     * @return callable
     */
    public static function getMiddleware(callable|array $validation, bool $newRecord = false): callable
    {

        return function(Request $request, RequestHandler $handler) use ($validation, $newRecord) : Response
        {

            $post = $request->getParsedBody();
            $errors = call_user_func_array($validation, [$post, $newRecord]);

            if (count($errors) !== 0)
            {

                $response = new \Slim\Psr7\Response();
                $response->getBody()->write(json_encode([
                    'error' => $errors
                ]));

                return $response
                    ->withStatus(400);

            }

            return $handler->handle($request);

        };

    }

}