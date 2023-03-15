<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseInterface;
use Contest\Database\{Station, User};
use Illuminate\Database\Connection;

class StationUser implements DatabaseInterface
{

    /**
     * Erzeugt dieses Objekt.
     *
     * @param Connection $connection
     */
    public function __construct(
        public readonly Connection $connection
    ){}


    /**
     * Entfernt alle Benutzer von den Stationen.
     *
     * @return void
     */
    public function down(): void {
        $this->connection->table('station_user')->delete();
    }


    /**
     * Fügt einige Benutzer den Stationen hinzu.
     *
     * @return void
     */
    public function up(): void
    {

        $users = User::query()->get();
        $stations = Station::query()->get();

        foreach($stations as $station) {
            $station->users()->saveMany( $users->random(rand(1,2)) );
        }

    }

}