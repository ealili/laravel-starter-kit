<?php

namespace App\Exceptions\Generic;

use Exception;

class DataCouldNotBeCreatedException extends Exception
{
    protected $code = 424;
}
