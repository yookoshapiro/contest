<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Database\User;
use Contest\Middleware\Api;
use Cake\Validation\Validator;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UserController
{

    /**
     * Gibt alle Benutzer wieder.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response): Response
    {

        $query = $request->getQueryParams();

        $users = User::query()->select(['id', 'name', 'is_active'])
            ->limit( $query['limit'] ?? 20 )
            ->get();

        if ($users->count() === 0)
        {

            $response->getBody()->write(json_encode([
                'error' => 'no users found'
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
     * Gibt einen Benutzer wieder.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {

        $response->getBody()->write(json_encode([
            'data' => $request->getAttribute('user')->load('stations:id,name')
        ]));

        return $response;

    }


    /**
     * Erzeugt einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {

        $newUser = new User;
        $post = $request->getParsedBody();

        foreach(['name', 'password', 'email', 'is_active', 'is_admin'] as $key)
        {

            if (array_key_exists($key, $post)) {
                $newUser->{$key} = $post[ $key ];
            }

        }

        $newUser->save();

        $response->getBody()->write(json_encode([
            'data' => [
                'created' => true,
                'id' => $newUser->id
            ]
        ]));

        return $response
            ->withStatus(201);

    }


    /**
     * Bearbeitet einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();
        $user = $request->getAttribute('user');

        foreach(['name', 'password', 'email', 'is_active', 'is_admin'] as $key)
        {

            if (array_key_exists($key, $post)) {
                $user->{$key} = $post[ $key ];
            }

        }

        $user->save();

        return $response
            ->withStatus(204);

    }


    /**
     * Löscht einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

        $request->getAttribute('user')->delete();

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route '/api/user'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->get('', [self::class, 'list']);

        $group->post('', [self::class, 'create'])
            ->add( Api\ValidationMiddleware::forCreating( [self::class, 'validation'] ) );

        $group->get('/{id}', [self::class, 'show'])
            ->add( Api\EntryMiddleware::fromQuery( User::class ) );

        $group->patch('/{id}', [self::class, 'edit'])
            ->add( Api\EntryMiddleware::fromQuery( User::class ) )
            ->add( Api\ValidationMiddleware::forUpdating( [self::class, 'validation'] ) );

        $group->delete('/{id}', [self::class, 'remove'])
            ->add( Api\EntryMiddleware::fromQuery( User::class ) );

    }


    /**
     * Validiert die Eingaben zu einem Benutzer und gibt alle Fehler als Array zurück.
     *
     * @param array $data
     * @param bool $newRecord [optional] default: true - true, wenn neuer Eintrag
     *                                                   false, wenn Eintrag aktualisiert wird
     * @return array
     */
    public static function validation(array $data, bool $newRecord = true): array
    {

        $validator = new Validator();

        $validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', ['length' => [
                'rule' => ['minLength', 3],
                'message' => 'The provided name needs to be at least 3 charakters long.'
            ]]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password', ['length' => [
                'rule' => ['minLength', 8],
                'message' => 'The provided password needs to be at least 8 charakters long.'
            ]]);

        $validator
            ->requirePresence('email', false)
            ->notEmptyString('email')
            ->add('email', "email_valid", [
                'rule' => "email",
                'message' => 'The provided e-mail must be valid.'
            ]);

        $validator
            ->requirePresence('is_active', false)
            ->add('is_active', 'active_type', ['rule' => 'boolean']);

        $validator
            ->requirePresence('is_admin', false)
            ->add('is_admin', 'admin_type', ['rule' => 'boolean'])
            ->add('is_admin', 'admin_rights', ['rule' => function() {
                return 'Admin rights are required to change that field.';
            }]);

        return $validator->validate($data, $newRecord);

    }

}