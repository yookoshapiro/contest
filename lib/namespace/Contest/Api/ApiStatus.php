<?php

declare(strict_types=1);

namespace Contest\Api;

enum ApiStatus: string
{

    case OK = 'OK';
    case OUT_OF_SERVICE = 'out of service';
    case MAINTENANCE = 'maintenance';

}
