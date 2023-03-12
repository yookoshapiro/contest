<?php

declare(strict_types=1);

namespace Contest\Controller;

use Contest\Middleware\Api;
use Contest\Database\Station;
use Cake\Validation\Validator;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Contest\Enum\{StationValueOrder, StationValueType};
use Psr\Http\Message\ServerRequestInterface as Request;

class StationController
{

    /**
     * Gibt eine Station wieder.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {

        $user = $request->getAttribute('station');
        $response->getBody()->write( $user->toJson() );

        return $response;

    }


    /**
     * Erzeugt eine Station.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {

        $newStation = new Station;
        $post = $request->getParsedBody();

        $newStation->name = $post['name'];

        if (array_key_exists('value_type', $post)) {
            $newStation->value_type = StationValueType::from( $post['value_type'] );
        }

        if (array_key_exists('value_order', $post)) {
            $newStation->value_order = StationValueOrder::from( $post['value_order'] );
        }

        $newStation->save();

        $response->getBody()->write(json_encode([
            'created' => true,
            'id' => $newStation->id
        ]));

        return $response
            ->withStatus(201);

    }


    /**
     * Bearbeitet eine Station.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();
        $station = $request->getAttribute('station');

        if (array_key_exists('name', $post)) {
            $station->name = $post['name'];
        }

        if (array_key_exists('value_type', $post)) {
            $station->value_type = StationValueType::from( $post['value_type'] );
        }

        if (array_key_exists('value_order', $post)) {
            $station->value_order = StationValueOrder::from( $post['value_order'] );
        }

        $station->save();

        return $response
            ->withStatus(204);

    }


    /**
     * Löscht eine Station.
     *
     * @param Request  $request
     * @param Response $response
     * @return Response
     */
    public function remove(Request $request, Response $response): Response
    {

        $request->getAttribute('station')->delete();

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route '/api/station'
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->post('', [self::class, 'create'])
            ->add( Api\ValidationMiddleware::forCreating( [self::class, 'validation'] ) );

        $group->get('/{id}', [self::class, 'show'])
            ->add( Api\EntryMiddleware::factory( Station::class ) );

        $group->patch('/{id}', [self::class, 'edit'])
            ->add( Api\EntryMiddleware::factory( Station::class ) )
            ->add( Api\ValidationMiddleware::forUpdating( [self::class, 'validation'] ) );

        $group->delete('/{id}', [self::class, 'remove'])
            ->add( Api\EntryMiddleware::factory( Station::class ) );

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

        $validator
            ->requirePresence('value_type', false)
            ->add('value_type', 'value_type_content', ['rule' => function($value, $context)
            {

                if (in_array($value, StationValueType::values())) {
                    return true;
                }

                return 'The provide value type need to be one of the following: ' . implode(' ,', StationValueType::values());

            }]);

        $validator
            ->requirePresence('value_order', false)
            ->add('value_order', 'value_order_content', ['rule' => function($value, $context)
            {

                if (in_array($value, StationValueOrder::values())) {
                    return true;
                }

                return 'The provide value order need to be one of the following: ' . implode(' ,', StationValueOrder::values());

            }]);


        return $validator->validate($data, $newRecord);

    }

}