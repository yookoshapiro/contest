<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseSeedInterface;
use Contest\Database\User;
use Faker\Factory;
use Illuminate\Support\Str;

class Users implements DatabaseSeedInterface
{

    /**
     * Entfernt alle Benutzer aus der Datenbank.
     *
     * @return void
     */
    public function down(): void {
        User::query()->delete();
    }


    /**
     * Fügt neue zufällige Benutzer in die Datenbank ein.
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
                'name' => $faker->userName,
                'password' => password_hash($faker->password, PASSWORD_DEFAULT),
                'email' => $faker->safeEmail
            ];

        }

        User::query()->insert($data);

    }

}