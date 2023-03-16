<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Artisan\Contract\DatabaseSeedInterface;
use Contest\Database\Team;
use Faker\Factory;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Teams implements DatabaseSeedInterface, DatabaseMigrateInterface
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
     * Entfernt alle Teams aus der Datenbank.
     *
     * @return void
     */
    public function down(): void {
        Team::query()->delete();
    }


    /**
     * Fügt neue zufällige Teams in die Datenbank ein.
     *
     * @param int $multiple
     * @return void
     */
    public function up(int $multiple = 1): void
    {

        $data = [];
        $faker = Factory::create('de_DE');

        for($i=0; $i<($multiple*10); $i++)
        {

            $data[] = [
                'id' => strtolower((string) Str::ulid()),
                'name' => $faker->company
            ];

            usleep(1);

        }

        Team::query()->insert($data);

    }


    /**
     * Zerstört die Stations-Tabelle.
     *
     * @return void
     */
    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('teams');
    }


    /**
     * Erzeugt die Stations-Tabelle
     *
     * @return void
     */
    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('teams')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('teams', function(Blueprint $table)
        {

            $table->ulid('id')->primary();
            $table->string('name', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

        });

    }

}