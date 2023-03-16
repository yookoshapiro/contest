<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property Station $station
 * @property Team $team
 * @property int $type
 * @property int $value
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Result extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Keine auto-incrementing für den Primärschlüssel
    public $incrementing = false;

    # Mass Assignment Werte
    protected $fillable = ['id', 'station_id', 'team_id', 'value', 'type'];

    # Many-To-One-Beziehung zur Stations-Tabelle
    public function station(): BelongsTo {
        return $this->belongsTo( Station::class );
    }

    # Many-To-One-Beziehung zur Teams-Tabelle
    public function team(): BelongsTo {
        return $this->belongsTo( Team::class );
    }

}