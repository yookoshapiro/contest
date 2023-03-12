<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Contest\Enum\{StationValueOrder, StationValueType};
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property StationValueType $value_type
 * @property StationValueOrder $value_order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Station extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Legt die Spalten fest, die in andere Typen umgewandelt werden soll
    protected $casts = [
        'value_type' => StationValueType::class,
        'value_order' => StationValueOrder::class
    ];

}