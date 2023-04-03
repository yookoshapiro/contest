<?php

declare(strict_types=1);

namespace Contest\Controller;

use Cake\Validation\Validator;
use Carbon\Carbon;
use Contest\Database\Login;
use Contest\Database\User;
use Contest\Middleware\Api\ValidationMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class AuthController
{

    /**
     * Verarbeitet eine Login-Anfrage.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();
        $user = User::query()
            ->select('id', 'password')
            ->where('name', '=', $post['name'])
            ->first();

        if($user === null) {
            return $this->login_failed($response, 1);
        }

        if(password_verify($post['password'], $user->password) !== true) {
            return $this->login_failed($response, 2);
        }

        $login = Login::query()
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->first();

        # Sollte es noch keinen Eintrag geben, erzeuge einen.
        if ($login === null)
        {

            $login = new Login;

            $login->user_id = $user->id;
            $login->expires_at = Carbon::now()->addHours(12);

            @$login->save();

        }

        $response->getBody()->write(json_encode([

            'data' => [
                'token' => $login->id,
                'expired_at' => $login->expires_at
            ]

        ]));

        return $response;

    }


    /**
     * Rückgabe bei einem gescheiterten Login-Versuch.
     *
     * @param Response $response
     * @param int      $code
     * @return Response
     */
    protected function login_failed(Response $response, int $code): Response
    {

        $response->getBody()->write(json_encode([
            'error' => 'login failed',
            'code' => $code
        ]));

        return $response
            ->withStatus(401);

    }


    /**
     * Verarbeitet eine Logout-Anfrage.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response): Response
    {

        $post = $request->getParsedBody();

        if (array_key_exists('token', $post))
        {

            $login = Login::query()
                ->where('id', '=', $post['token'])
                ->first();

            $login?->delete();

        }

        return $response
            ->withStatus(204);

    }


    /**
     * Router für die Route '/api/auth'.
     *
     * @param RouteCollectorProxy $group
     * @return void
     */
    public static function router(RouteCollectorProxy $group): void
    {

        $group->post('/login', [self::class, 'login'])
            ->add( ValidationMiddleware::forCreating( [self::class, 'loginValidation'] ) );

        $group->post('/logout', [self::class, 'logout']);

    }


    /**
     * Validiert die Eingaben für einen Login-Versuch.
     *
     * @param array $data
     * @param bool  $newRecord
     * @return array
     */
    public static function loginValidation(array $data, bool $newRecord): array
    {

        $validator = new Validator();

        $validator
            ->requirePresence('name')
            ->notEmptyString('name');

        $validator
            ->requirePresence('password')
            ->notEmptyString('password');

        return $validator->validate($data, $newRecord);

    }

}