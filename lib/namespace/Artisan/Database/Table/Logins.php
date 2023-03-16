<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;

class Logins implements DatabaseMigrateInterface
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
     * Zerstört die Stations-Tabelle.
     *
     * @return void
     */
    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('logins');
    }


    /**
     * Erzeugt die Stations-Tabelle
     *
     * @return void
     */
    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('logins')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('logins', function(Blueprint $table)
        {

            $table->uuid('id')->primary();
            $table->ulid('user_id');
            $table->dateTime('expires_at');

        });

    }

}