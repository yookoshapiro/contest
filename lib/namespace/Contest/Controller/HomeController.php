<?php

declare(strict_types=1);

namespace Contest\Controller;

use Psr\Http\Message\{RequestInterface, ResponseInterface};
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class HomeController
{

    /**
     * Startseite.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(RequestInterface $request, ResponseInterface $response): ResponseInterface {
        return Twig::fromRequest($request)->render($response, 'index.twig');
    }


    /**
     * Aufruf der Klasse als Funktion.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->index($request, $response);
    }

}