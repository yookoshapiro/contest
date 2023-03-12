<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Model für die teams-Tabelle.
 *
 * @property string $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Team extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

}