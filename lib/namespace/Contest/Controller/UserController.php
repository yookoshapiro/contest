<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Database\User;
use Cake\Validation\Validator;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UserController
{

    /**
     * Zeigt einen Benutzer an.
     *
     * @param Request $request
     * @param Response $response
     * @param array $attr
     * @return Response
     */
    public function show(Request $request, Response $response, array $attr): Response
    {

        try
        {

            $user = User::findOrFail( $attr['id'] );
            $response->getBody()->write( $user->toJson() );

            return $response;

        }
        catch (\Exception $ex)
        {

            $response->getBody()->write(json_encode([
                'error' => "no user with id '{$attr['id']}' found"
            ]));

            return $response
                ->withStatus(404);

        }

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

        $newUser->name = $post['name'];
        $newUser->password = password_hash($post['name'], PASSWORD_DEFAULT);

        foreach(['email', 'active', 'is_admin'] as $key)
        {

            if (array_key_exists($key, $post)) {
                $newUser->{$key} = $post[ $key ];
            }

        }

        $newUser->save();

        $response->getBody()->write(json_encode([
            'created' => true,
            'id' => $newUser->id
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

        return $response
            ->withStatus(204);

    }


    /**
     * Entfernt einen Benutzer.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

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

        $group->post('', [self::class, 'create'])->add( self::getValidationMiddleware(true) );
        $group->get('/{id}', [self::class, 'show']);
        $group->patch('/{id}', [self::class, 'edit'])->add( self::getValidationMiddleware() );
        $group->delete('/{id}', [self::class, 'remove'])->add( self::getValidationMiddleware() );

    }


    /**
     * Gibt eine Middleware zum Validieren der Benutzereingaben wieder.
     *
     * @param bool $newRecord
     * @return callable
     */
    public static function getValidationMiddleware(bool $newRecord = false): callable
    {

        return function($request, $handler) use ($newRecord)
        {

            $post = $request->getParsedBody();
            $errors = self::dataValidation($post, $newRecord);

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


    /**
     * Validiert die Eingaben zu einem Benutzer und gibt alle Fehler als Array zurück
     *
     * @param array $data
     * @param bool $newRecord [optional] default: true - true, wenn neuer Eintrag
     *                                                   false, wenn Eintrag aktualisiert wird
     * @return array
     */
    protected static function dataValidation(array $data, bool $newRecord = true): array
    {

        $validator = new Validator();

        $validator
            ->requirePresence('id', 'update')
            ->add('id', 'id_length', ['rule' => function($value, $context)
            {

                if ($context['newRecord'] === true or strlen($value) === 26) {
                    return true;
                }

                return 'The id is to ' . (strlen($value) < 26 ? 'short.' : 'long.');

            }]);

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
            ->requirePresence('active', false)
            ->add('active', 'active_type', ['rule' => 'boolean']);

        $validator
            ->requirePresence('is_admin', false)
            ->add('is_admin', 'admin_type', ['rule' => 'boolean'])
            ->add('is_admin', 'admin_rights', ['rule' => function() {
                return 'To change this field, admin rights are required.';
            }]);

        return $validator->validate($data, $newRecord);

    }

}