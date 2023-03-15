<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseInterface;
use Contest\Database\Station;
use Faker\Factory;
use Illuminate\Support\Str;

class Stations implements DatabaseInterface
{

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

}