<?php

namespace App\Exceptions;

use Throwable;

class UnauthorizedException extends \Exception
{
    public function __construct($message = 'Unauthorized! You shall not pass!', $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
