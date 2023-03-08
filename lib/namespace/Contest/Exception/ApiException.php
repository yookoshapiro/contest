<?php

declare(strict_types=1);

namespace Contest\Exception;

use Exception;

class ApiException extends Exception
{

    public static function createFromException(Exception $ex): self {
        return new self($ex->message, $ex->code, $ex);
    }

}