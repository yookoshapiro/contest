<?php

declare(strict_types=1);

namespace Contest\Controller;

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

        $payload = json_encode([
            'id' => $attr['id'],
            'name' => 'Yooko Shapiro'
        ]);
        $response->getBody()->write($payload);

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
        $group->get('/{id}', [self::class, 'show'])->add( self::getValidationMiddleware() );
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
                $response->getBody()->write( json_encode($errors) );

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
            ->requirePresence('id', 'update', 'Die ID wird benötigt.')
            ->add('id', 'id_length', [
                'rule' => function($value, $context)
                {

                    if ($context['newRecord'] === true or strlen($value) === 36) {
                        return true;
                    }

                    return 'Die ID ist zu ' . (strlen($value) < 36 ? 'kurz.' : 'lang.');

                }
            ]);

        $validator
            ->requirePresence('phrase', false)
            ->add('phrase', 'phrase_length', [
            'rule' => function($value, $context)
            {

                if ($context['newRecord'] === true or strlen($value) === 8) {
                    return true;
                }

                return 'Die Phrase ist zu ' . (strlen($value) < 8 ? 'kurz.' : 'lang.');

            }
        ]);

        $validator
            ->requirePresence('name', 'create', 'Der Name wird benötigt.')
            ->notEmptyString('name', 'Der Name darf nicht leer sein.')
            ->add('name', [
                'length' => [
                    'rule' => ['minLength', 3],
                    'message' => 'Der Name muss min. 3 Zeichen lang sein.'
                ]
            ]);

        $validator
            ->requirePresence('password', 'create', 'Ein Passwort wird benötigt.')
            ->notEmptyString('password', 'Das Passwort darf nicht leer sein.')
            ->add('password', [
                'length' => [
                    'rule' => ['minLength', 8],
                    'message' => 'Das Passwort muss min. 8 Zeichen lang sein.'
                ]
            ]);

        $validator
            ->requirePresence('email', false)
            ->notEmptyString('email', 'Die E-Mail darf nicht leer sein.')
            ->add('email', "email_valid", [
                'rule' => "email",
                'message' => 'Es muss eine gültige E-Mail sein.'
            ]);

        $validator
            ->requirePresence('active', false)
            ->add('active', 'active_type', [
                'rule' => 'boolean'
            ]);

        return $validator->validate($data, $newRecord);

    }

}