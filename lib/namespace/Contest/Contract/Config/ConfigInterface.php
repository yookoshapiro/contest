<?php

declare(strict_types=1);

namespace Contest\Contract\Config;

interface ConfigInterface
{

    /**
     * Speichert einen Wert in den Einstellungen. Überschreibt einen bereits vorhanden Wert.
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    public function set(string $key, mixed $value): void;


    /**
     * Gibt zurück, ob es den gesuchten Schlüssel gibt.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;


    /**
     * Gibt einen Wert aus den Einstellungen wieder.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get(string $key, mixed $default): mixed;

}