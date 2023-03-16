<?php

declare(strict_types=1);

use Artisan\Database\Table;

return [

    /**
     * Eine Reihe von Klassen, die Aktionen an der Datenbank ausführen.
     * Alle sollte 'Artisan\Contract\DatabaseInterface' einbinden.
     *
     * Die Reihenfolge der Klasse stellt auch die Reihenfolge der Aufrufe dar.
     * Sollte also eine Klasse Daten aus einer anderen benötigen, muss diese später eingebunden werden.
     */
    'database' => [
        Table\Users::class,
        Table\Stations::class,
        Table\Teams::class,
        Table\StationUser::class,
        Table\Logins::class,
        Table\Results::class
    ]

];