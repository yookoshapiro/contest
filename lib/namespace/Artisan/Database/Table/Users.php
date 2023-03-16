<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Artisan\Contract\DatabaseSeedInterface;
use Contest\Database\User;
use Faker\Factory;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Users implements DatabaseSeedInterface, DatabaseMigrateInterface
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


    /**
     * Zerstört die Benutzer-Tabelle.
     *
     * @return void
     */
    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('users');
    }


    /**
     * Erzeugt die Benutzer-Tabelle
     *
     * @return void
     */
    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('users')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('users', function(Blueprint $table)
        {

            $table->ulid('id')->primary();
            $table->string('name')->index();
            $table->string('password', 100);
            $table->string('email');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(true);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

        });

    }

}