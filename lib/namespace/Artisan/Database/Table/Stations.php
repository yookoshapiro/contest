<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Artisan\Contract\DatabaseSeedInterface;
use Contest\Database\Station;
use Faker\Factory;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Stations implements DatabaseSeedInterface, DatabaseMigrateInterface
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
     * Entfernt alle Stationen aus der Datenbank.
     *
     * @return void
     */
    public function down(): void {
        Station::query()->delete();
    }


    /**
     * Fügt neue zufällige Station in die Datenbank ein.
     *
     * @param int $multiple
     * @return void
     */
    public function up(int $multiple = 1): void
    {

        $data = [];
        $faker = Factory::create('de_DE');

        for($i=0; $i<($multiple*5); $i++)
        {

            $data[] = [
                'id' => strtolower((string) Str::ulid()),
                'name' => $faker->word,
                'type' => $faker->numberBetween(2, 31)
            ];

            usleep(1);

        }

        Station::query()->insert($data);

    }


    /**
     * Zerstört die Stations-Tabelle.
     *
     * @return void
     */
    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('stations');
    }


    /**
     * Erzeugt die Stations-Tabelle
     *
     * @return void
     */
    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('stations')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('stations', function(Blueprint $table)
        {

            $table->ulid('id')->primary();
            $table->string('name', 100);
            $table->integer('type')->default(2);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

        });

    }


}