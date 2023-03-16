<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Database\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

class ResultsController
{

    /**
     * Gibt alle Teams wieder.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response): Response
    {

        $query = $request->getQueryParams();
        $results = Result::query()
            ->limit( $query['limit'] ?? 20 )
            ->get();

        if ($results->count() === 0)
        {

            $response->getBody()->write(json_encode([
                'error' => 'no results found'
            ]));

            return $response
                ->withStatus(404);

        }

        $data = $results->map(function($result)
        {

            return [
                'id' => $result->id,
                'station' => [
                    'id' => $result->station->id,
                    'name' => $result->station->name
                ],
                'team' => [
                    'id' => $result->team->id,
                    'name' => $result->team->name
                ],
                'type' => $result->type,
                'value' => $result->value,
                'comment' => $result->comment,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at
            ];

        });

        $response->getBody()->write(json_encode([
            'data' => $data
        ]));

        return $response;

    }


    /**
     * Router für die Route 'api/results'
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void {
        $group->get('', [self::class, 'list']);
    }

}