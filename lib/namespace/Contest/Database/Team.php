<?php

declare(strict_types=1);

namespace Contest\Database;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    # Aktiviere Ulids als PrimaryKey
    use HasUlids;

}