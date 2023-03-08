<?php

declare(strict_types=1);

namespace Contest\Controller;

use Psr\Http\Message\{RequestInterface, ResponseInterface};

final class HomeController extends AbstractController
{

    /**
     * Startseite.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $response->getBody()->write('Hello World!');
        return $response;

    }


    /**
     * Aufruf der Klasse als Funktion.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->index($request, $response);
    }

}