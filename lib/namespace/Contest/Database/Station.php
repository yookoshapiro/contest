<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Contest\Database\Casts\StationType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $name
 * @property array $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $users
 */
class Station extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Diese Felder nicht anzeigen
    protected $hidden = ['pivot'];

    # Legt die Spalten fest, die in andere Typen umgewandelt werden soll
    protected $casts = [
        'type' => StationType::class
    ];


    /**
     * Mana-To-Many-Beziehung zwischen Station und User herstellen.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany {
        return $this->belongsToMany( User::class );
    }

}