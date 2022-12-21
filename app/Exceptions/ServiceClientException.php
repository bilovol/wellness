<?php

namespace App\Exceptions;

use Throwable;

class ServiceClientException extends \Exception
{
    public function __construct($message = 'Undefined error!', $code = 800, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
