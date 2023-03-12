<?php

declare(strict_types=1);

namespace Contest\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Model
{

    use HasUuids;

}