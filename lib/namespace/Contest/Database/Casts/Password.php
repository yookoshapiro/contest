<?php

declare(strict_types=1);

namespace Contest\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Password implements CastsAttributes
{

    /**
     * Gibt Daten aus der Datenbank wieder.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return string
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string {
        return $value;
    }


    /**
     * Setzt Daten für die Datenbank.
     *
     * @param Model  $model
     * @param string $key
     * @param mixed  $value
     * @param array  $attributes
     * @return string
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string {
        return password_hash($value, PASSWORD_DEFAULT);
    }

}