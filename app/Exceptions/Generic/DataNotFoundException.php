<?php

namespace App\Exceptions\Generic;

use Exception;

class DataNotFoundException extends Exception
{
    protected $code = 404;
}
