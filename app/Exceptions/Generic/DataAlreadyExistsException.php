<?php

namespace App\Exceptions\Generic;

use Exception;

class DataAlreadyExistsException extends Exception
{
    protected $code = 409;
}
