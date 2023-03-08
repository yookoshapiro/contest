<?php

declare(strict_types=1);

namespace Contest\Controller;

use Psr\Container\ContainerInterface as Container;

abstract class AbstractController
{

    /**
     * Erzeugt diese Klasse.
     *
     * @param Container $container
     */
    final public function __construct(
        protected Container $container
    ) {}

}