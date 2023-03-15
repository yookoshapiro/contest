<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseInterface;
use Contest\Database\Team;
use Faker\Factory;
use Illuminate\Support\Str;

class Teams implements DatabaseInterface
{

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

}