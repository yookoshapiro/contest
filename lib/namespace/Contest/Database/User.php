<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Contest\Database\Casts\Password;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model für die users-Tabelle.
 *
 * @property string $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property bool $is_active
 * @property bool $is_admin
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $stations
 * @property Login $login
 */
class User extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Diese Felder nicht anzeigen
    protected $hidden = ['password', 'pivot'];

    # Legt die Spalten fest, die in andere Typen umgewandelt werden soll
    protected $casts = [
        'is_active' => 'bool',
        'is_admin' => 'bool',
        'password' => Password::class
    ];

    # Many-To-Many-Beziehung zur Stations-Tabelle
    public function stations(): BelongsToMany {
        return $this->belongsToMany( Station::class );
    }


    public function login(): HasOne {
        return $this->HasOne( Login::class );
    }

}