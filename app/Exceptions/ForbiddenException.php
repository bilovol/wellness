<?php

namespace App\Exceptions;

use Throwable;

class ForbiddenException extends \Exception
{
    public function __construct($message = 'Locked request!', $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
