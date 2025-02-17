<?php

namespace App\Exceptions;

use Exception;

class InvalidPlayerException extends Exception
{
    protected $message = 'Invalid player provided';
}