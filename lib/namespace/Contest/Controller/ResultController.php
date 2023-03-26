<?php

declare(strict_types=1);

namespace Contest\Controller;

use Cake\Validation\Validator;
use Contest\Database\Result;
use Contest\Database\Station;
use Contest\Database\Team;
use Contest\Enum\StationType;
use Contest\Middleware\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

class ResultController
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
        $results = Result::with(['station:id,name,type', 'team:id,name'])
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

        $response->getBody()->write(json_encode([
            'data' => $results
        ]));

        return $response;

    }


    /**
     * Zeigt ein Ergebnis.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {

        $response->getBody()->write(json_encode([
            'data' => $request->getAttribute('result')
        ]));

        return $response;

    }


    /**
     * Erzeugt ein Ergebnis.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {

        $station = $request->getAttribute('station');
        $team = $request->getAttribute('team');
        $post = $request->getParsedBody();

        $newResult = new Result([
            'station_id' => $station->id,
            'team_id' => $team->id,
            'value' => $post['value'],
            'type' => $post['type']
        ]);

        if (array_key_exists('comment', $post) and ! empty($post['comment'])) {
            $newResult->comment = $post['comment'];
        }

        try {
            $newResult->save();
        }
        catch(\Exception $ex)
        {

            $response->getBody()->write(json_encode([
                'error' => 'duplicate entry for result'
            ]));

            return $response
                ->withStatus(409);

        }

        $response->getBody()->write(json_encode([
            'data' => [
                'created' => true,
                'id' => $newResult->id
            ]
        ]));

        return $response
            ->withStatus(201);

    }


    /**
     * Bearbeitet ein Ergebnis.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();
        $result = $request->getAttribute('result');

        if (array_key_exists('station_id', $post))
        {

            $station = Station::find($post['station_id']);

            if ($station === null)
            {

                $response->getBody()->write(json_encode([
                    'error' => "no station with id '{$post['station_id']}' found"
                ]));

                return $response
                    ->withStatus(404);

            }

            $result->station_id = $station->id;

        }

        if (array_key_exists('team_id', $post))
        {

            $station = Team::find($post['team_id']);

            if ($station === null)
            {

                $response->getBody()->write(json_encode([
                    'error' => "no team with id '{$post['team_id']}' found"
                ]));

                return $response
                    ->withStatus(404);

            }

            $result->station_id = $station->id;

        }

        if (array_key_exists('comment', $post)) {
            $result->comment = empty($post['comment']) ? null : $post['comment'];
        }

        foreach(['type', 'value'] as $key)
        {

            if (array_key_exists($key, $post)) {
                $result->{$key} = $post[ $key ];
            }

        }

        try {
            $result->save();
        }
        catch(\Exception $ex)
        {

            $response->getBody()->write(json_encode([
                'error' => "duplicated entry found"
            ]));

            return $response
                ->withStatus(404);

        }

        return $response
            ->withStatus(204);

    }


    /**
     * Entfernt ein Ergebnis.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

        $request->getAttribute('result')->delete();

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route 'api/result'
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->get('', [self::class, 'list']);

        $group->post('', [self::class, 'create'])
            ->add( Api\ValidationMiddleware::forCreating( [self::class, 'validation'] ) )
            ->add( Api\EntryMiddleware::fromBody( Station::class, 'station_id' ) )
            ->add( Api\EntryMiddleware::fromBody( Team::class, 'team_id' ) );

        $group->get('/{id}', [self::class, 'show'])
            ->add( Api\EntryMiddleware::fromQuery( Result::class ) );

        $group->patch('/{id}', [self::class, 'edit'])
            ->add( Api\ValidationMiddleware::forUpdating( [self::class, 'validation'] ) )
            ->add( Api\EntryMiddleware::fromQuery( Result::class ) );

        $group->delete('/{id}', [self::class, 'remove'])
            ->add( Api\EntryMiddleware::fromQuery( Result::class ) );

    }


    /**
     * Validiert die Eingaben zu einem Team und gibt alle Fehler als Array zurück.
     *
     * @param array $data
     * @param bool $newRecord [optional] default: true - true, wenn neuer Eintrag
     *                                                   false, wenn Eintrag aktualisiert wird
     * @return array
     */
    public static function validation(array $data, bool $newRecord): array
    {

        $validator = new Validator();

        $validator
            ->requirePresence('station_id', false)
            ->notEmptyString('station_id');

        $validator
            ->requirePresence('team_id', false)
            ->notEmptyString('team_id');

        $validator
            ->requirePresence('type', false)
            ->inList('type', array_slice(StationType::values(), 1), "The provided value needs to be on of this: " . implode(', ', array_slice(StationType::values(), 1)));

        $validator
            ->requirePresence('value', 'create')
            ->integer('value');

        return $validator->validate($data, $newRecord);

    }

}