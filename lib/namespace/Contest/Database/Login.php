<?php

declare(strict_types=1);

namespace Contest\Database;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $user_id
 * @property Carbon $expires_at
 * @property User $user
 */
class Login extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUuids;

    # Deaktiviert die Timestamps
    public $timestamps = false;

    # Gibt das Format für bestimmte Felder an.
    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }

}