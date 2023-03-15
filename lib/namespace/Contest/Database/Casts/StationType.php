<?php

declare(strict_types=1);

namespace Contest\Database\Casts;

use Contest\Enum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;

class StationType implements CastsAttributes, SerializesCastableAttributes
{

    /**
     * Gibt Daten aus der Datenbank wieder.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return array
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array {
        return Enum\StationType::extract($value);
    }


    /**
     * Setzt Daten für die Datenbank.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return int
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int {
        return Enum\StationType::combine($value);
    }


    /**
     * Daten für Serialisierung vorbereiten.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return int
     */
    public function serialize(Model $model, string $key, mixed $value, array $attributes): int {
        return Enum\StationType::combine($value);
    }

}