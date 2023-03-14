<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Contest\Database\Casts\StationType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property array $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Station extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Legt die Spalten fest, die in andere Typen umgewandelt werden soll
    protected $casts = [
        'type' => StationType::class
    ];

}