<?php

declare(strict_types=1);

namespace Artisan\Database\Table;

use Artisan\Contract\DatabaseMigrateInterface;
use Artisan\Contract\DatabaseSeedInterface;
use Contest\Database\Result;
use Contest\Database\Station;
use Contest\Database\Team;
use Contest\Enum\StationType;
use Faker\Factory;
use Generator;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class Results implements DatabaseSeedInterface, DatabaseMigrateInterface
{

    /**
     * Erzeugt dieses Objekt.
     *
     * @param Connection $connection
     */
    public function __construct(
        public readonly Connection $connection
    ){}


    public function down(): void {
        Result::query()->delete();
    }


    public function up(): void
    {

        $this->connection->transaction(function()
        {

            $faker = Factory::create('de_DE');

            /* @var Station[] $stations */
            $stations = Station::query()->get();

            /* @var Team[] $teams */
            $teams = Team::query()->get();

            foreach($stations as $station)
            {

                foreach ($teams as $team)
                {

                    foreach ($this->fakeValue($station->type) as $type => $value)
                    {

                        $result = new Result([
                            'id' => strtolower((string) Str::ulid()),
                            'station_id' => $station->id,
                            'team_id' => $team->id,
                            'value' => $value,
                            'type' => $type->value
                        ]);

                        if (mt_rand(1, 15) === 1) {
                            $result->comment = $faker->text(50);
                        }

                        try {
                            $result->save();
                        }
                        catch(\Exception $ex) {}

                    }

                }

            }

        });

    }


    /**
     * @param StationType[] $types
     * @return Generator
     */
    protected function fakeValue(array $types): Generator
    {

        $faker = Factory::create('de_DE');

        foreach($types as $type)
        {

            switch ($type)
            {

                case StationType::TIME:
                    yield StationType::TIME => $faker->numberBetween(5000, 50000);
                    break;

                case StationType::POINTS:
                    yield StationType::POINTS => $faker->numberBetween(5, 50);
                    break;

                case StationType::DISTANCE:
                    yield StationType::DISTANCE => $faker->numberBetween(1000, 10000);
                    break;

                case StationType::ESTIMATE:
                    yield StationType::ESTIMATE => $faker->numberBetween(3000, 8000);
                    break;

                case StationType::DESC:
                    break;

            }

        }

    }


    public function destroy(): void {
        $this->connection->getSchemaBuilder()->dropIfExists('results');
    }


    public function create(): void
    {

        if ($this->connection->getSchemaBuilder()->hasTable('results')) {
            return;
        }

        $this->connection->getSchemaBuilder()->create('results', function(Blueprint $table)
        {

            $table->ulid('id')->primary();
            $table->ulid('station_id');
            $table->ulid('team_id');
            $table->integer('type');
            $table->integer('value');
            $table->text('comment')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(['station_id', 'team_id', 'type']);

        });

    }

}