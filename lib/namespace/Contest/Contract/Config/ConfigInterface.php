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
     * @return ConfigInterface
     */
    public function set(string $key, mixed $value): ConfigInterface;

}