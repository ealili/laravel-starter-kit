<?php

namespace App\Exceptions\Generic;

use Exception;

class BadRequestException extends Exception
{
    protected $code = 400;
}
