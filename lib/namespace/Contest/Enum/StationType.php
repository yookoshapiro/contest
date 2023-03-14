<?php

declare(strict_types=1);

namespace Contest\Enum;

enum StationType: int
{

    # Sortieren der Ergebnisse rückwärts
    case DESC = 1;

    # Erfassung mit einem Zeitwert
    case TIME = 2;

    # Erfassung mit einem Punktewert
    case POINTS = 4;

    # Erfassung mit einem Entfernungswert
    case DISTANCE = 8;

    # Erfassung mit einem Schätzwert
    case ESTIMATE = 16;


    /**
     * Gibt alle Werte des Enums wieder.
     *
     * @return array
     */
    public static function values(): array {
        return array_column(self::cases(), 'value');
    }


    /**
     * Gibt ein Array mit allen in der übergebene Zahl enthaltenen Typen wieder.
     *
     * @param int $type
     * @return array
     */
    public static function extract(int $type): array
    {

        $result = [];

        foreach( self::values() as $value )
        {
            if (($type & $value) === $value) {
                $result[] = self::from($value);
            }

        }

        return $result;

    }


    /**
     * Gibt die Gesamte-Summe aller Typen zusammen.
     *
     * @param  StationType[] $data
     * @return int
     */
    public static function combine(array $data): int
    {

        $start = 0;

        foreach ($data as $item)
        {

            if (!$item instanceof self) {
                throw new \InvalidArgumentException(self::class . ' expected, ' . gettype($item) . ' given');
            }

            $start += $item->value;

        }

        return $start;

    }

}
