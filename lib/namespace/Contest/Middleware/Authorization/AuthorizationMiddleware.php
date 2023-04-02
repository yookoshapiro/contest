<?php

declare(strict_types=1);

namespace Contest\Middleware\Authorization;

use Contest\Database\Login;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Uid\Uuid;

class AuthorizationMiddleware implements MiddlewareInterface
{

    public function process(Request $request, RequestHandler $handler): Response
    {

        if (($token = $this->getToken($request)) === null) {
            $this->unauthorized();
        }

        $login = Login::with('user:id,name,is_active,is_admin')
            ->where('id', $token)
            ->first();

        if ($login === null) {
            return $this->unauthorized();
        }

        $request = $request->withAttribute('user', $login->user);

        return $handler
            ->handle($request);

    }


    protected function getToken(Request $request): ?string
    {

        if ($request->hasHeader('Authorization') !== true) {
            return null;
        }

        $bearer = $request->getHeader('Authorization')[0];

        if (str_starts_with($bearer, 'Bearer ') === false) {
            return null;
        }

        $explode = explode(' ', $bearer);

        if (count($explode) !== 2) {
            return null;
        }

        $token = array_pop($explode);

        if ($token === null or Uuid::isValid($token) === false) {
            return null;
        }

        return $token;

    }


    protected function unauthorized(): Response
    {

        $response = (new ResponseFactory)
            ->createResponse(StatusCodeInterface::STATUS_UNAUTHORIZED);

        $response->getBody()->write( json_encode([
            'error' => 'unauthorized'
        ]) );

        return $response;

    }

}