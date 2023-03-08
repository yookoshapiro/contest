<?php

declare(strict_types=1);

namespace Contest;

use Dotenv\Dotenv;
use Contest\Contract\Config\ConfigInterface;

class Config implements ConfigInterface
{

    protected array $storage = [];

    /**
     * Erzeugt diese Klasse.
     *
     * @param Dotenv $dotenv
     */
    public function __construct(Dotenv $dotenv) {
        $dotenv->load();
    }


    /**
     * Speichert einen Wert in den Einstellungen. Überschreibt einen bereits vorhanden Wert.
     *
     * @param string $key
     * @param mixed  $value
     * @return ConfigInterface
     */
    public function set(string $key, mixed $value): ConfigInterface
    {

        $this->storage[ $key ] = $value;

        return $this;

    }

}