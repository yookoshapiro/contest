<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Database\Station;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

class StationsController
{

    /**
     * Gibt alle Stationen wieder.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response): Response
    {

        $query = $request->getQueryParams();

        $users = Station::with('results:id,station_id,team_id,type,value,comment')
            ->select(['id', 'name', 'type'])
            ->limit( $query['limit'] ?? 20 )
            ->get();

        if ($users->count() === 0)
        {

            $response->getBody()->write(json_encode([
                'error' => 'no station found'
            ]));

            return $response
                ->withStatus(404);

        }

        $response->getBody()->write(json_encode([
            'data' => $users
        ]));

        return $response;

    }


    /**
     * Routen für die Route '/api/users'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void {
        $group->get('', [self::class, 'list']);
    }

}