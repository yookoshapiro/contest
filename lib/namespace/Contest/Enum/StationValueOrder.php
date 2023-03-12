<?php

declare(strict_types=1);

namespace Contest\Enum;

enum StationValueOrder: string
{

    # Sortieren nach kleinsten/dichtesten Wert
    case ASC = 'asc';

    # Sortieren nach größtem/entferntesten Wert
    case DESC = 'desc';


    /**
     * Gibt alle Werte des Enums wieder.
     *
     * @return array
     */
    public static function values(): array {
        return array_column(self::cases(), 'value');
    }

}
