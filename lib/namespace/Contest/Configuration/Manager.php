<?php

declare(strict_types=1);

namespace Contest\Configuration;

use Contest\Contract\Config\ConfigInterface;
use Contest\Exception\ConfigException;
use Dotenv\Dotenv;

class Manager implements ConfigInterface
{

    protected array $storage = [];

    /**
     * Erzeugt diese Klasse.
     *
     * @param string $path
     * @param Dotenv $dotenv
     */
    public function __construct(
        readonly string $path,
        Dotenv $dotenv
    ) {
        $dotenv->load();
    }


    /**
     * Speichert einen Wert in den Einstellungen. Überschreibt einen bereits vorhanden Wert.
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public function set(string $key, mixed $value): void {
        $this->storage[ $key ] = $value;
    }


    /**
     * Gibt zurück, ob es den gesuchten Schlüssel gibt.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool {
        return array_get($this->storage, $key) !== null;
    }


    /**
     * Gibt einen Wert aus den Einstellungen wieder.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     * @throws ConfigException
     */
    public function get(string $key, mixed $default = null): mixed
    {

        $keys = explode('.', $key);

        $data = $this->read( head($keys) );
        $key = implode('.', array_slice($keys, 1));

        return array_get($data, $key, $default);

    }


    /**
     * Liest eine Konfiguration-Datei ein und gibt deren Inhalt wieder.
     *
     * @param string $name
     * @return mixed
     * @throws ConfigException
     */
    protected function read(string $name): mixed
    {

        if ( isset($this->storage[$name]) ) {
            return $this->storage[ $name ];
        }

        $path = $this->path . $name . '.php';

        if ( ! file_exists($path) ) {
            throw new ConfigException("unknown configuration '{$name}', {$path}");
        }

        return $this->storage[ $name ] = require $path;

    }

}