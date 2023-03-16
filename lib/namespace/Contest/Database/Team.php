<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Model für die teams-Tabelle.
 *
 * @property string $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $results
 */
class Team extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # One-To-Many-Beziehung zur Results-Tabelle
    public function results(): HasMany {
        return $this->hasMany( Result::class );
    }

}