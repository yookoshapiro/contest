<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Database\Team;
use Contest\Middleware\Api;
use Cake\Validation\Validator;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class TeamController
{


    /**
     * Gibt ein Team wieder.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {

        $user = $request->getAttribute('team');
        $response->getBody()->write( $user->toJson() );

        return $response;

    }


    /**
     * Erzeugt ein Team.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {

        $newTeam = new Team;
        $post = $request->getParsedBody();

        $newTeam->name = $post['name'];
        $newTeam->save();

        $response->getBody()->write(json_encode([
            'created' => true,
            'id' => $newTeam->id
        ]));

        return $response
            ->withStatus(201);

    }


    /**
     * Bearbeitet ein Team.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();
        $team = $request->getAttribute('team');

        if (array_key_exists('name', $post)) {
            $team->name = $post['name'];
        }

        $team->save();

        return $response
            ->withStatus(204);

    }


    /**
     * Löscht ein Team.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

        $request->getAttribute('team')->delete();

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route '/api/team'
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->post('', [self::class, 'create'])
            ->add( Api\ValidationMiddleware::forCreating( [self::class, 'validation'] ) );

        $group->get('/{id}', [self::class, 'show'])
            ->add( Api\EntryMiddleware::factory( Team::class ) );

        $group->patch('/{id}', [self::class, 'edit'])
            ->add( Api\EntryMiddleware::factory( Team::class ) )
            ->add( Api\ValidationMiddleware::forUpdating( [self::class, 'validation'] ) );

        $group->delete('/{id}', [self::class, 'remove'])
            ->add( Api\EntryMiddleware::factory( Team::class ) );

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
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', ['length' => [
                'rule' => ['minLength', 3],
                'message' => 'The provided name needs to be at least 3 charakters long.'
            ]]);

        return $validator->validate($data, $newRecord);

    }

}