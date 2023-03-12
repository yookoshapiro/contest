<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

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
 */
class User extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

    # Passwort nicht standardmäßig anzeigen
    protected $hidden = ['password'];

    # Legt die Spalten fest, die in andere Typen umgewandelt werden soll
    protected $casts = [
        'is_active' => 'bool',
        'is_admin' => 'bool'
    ];

}