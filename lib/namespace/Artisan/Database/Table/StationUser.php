<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Artisan\Contract\DatabaseSeedInterface;
use Illuminate\Database\Schema\Blueprint;
use Contest\Database\{Station, User};
use Illuminate\Database\Connection;

class StationUser implements DatabaseSeedInterface, DatabaseMigrateInterface
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
            try {
                $station->users()->saveMany( $users->random(rand(1,2)) );
            }
            catch (\Exception $ex) {}
        }

    }


    /**
     * Zerstört die Stations-Tabelle.
     *
     * @return void
     */
    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('station_user');
    }


    /**
     * Erzeugt die Stations-Tabelle
     *
     * @return void
     */
    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('station_user')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('station_user', function(Blueprint $table)
        {

            $table->ulid('station_id');
            $table->ulid('user_id');
            $table->primary(['station_id', 'user_id']);

        });

    }

}