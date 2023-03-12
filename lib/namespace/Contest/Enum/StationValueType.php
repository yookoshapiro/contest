<?php

declare(strict_types=1);

namespace Contest\Enum;

enum StationValueType: int
{

    # Erfassung mit einem Zeitwert
    case TIME = 1;

    # Erfassung mit einem Punktewert
    case POINTS = 2;

    # Erfassung mit einem Entfernungswert
    case DISTANCE = 4;

    # Erfassung mit einem Schätzwert
    case ESTIMATE = 8;


    /**
     * Gibt alle Werte des Enums wieder.
     *
     * @return array
     */
    public static function values(): array {
        return array_column(self::cases(), 'value');
    }

}
