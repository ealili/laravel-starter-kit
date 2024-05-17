<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Generic\BadRequestException;
use JetBrains\PhpStorm\Pure;

class InvalidEmailOrPasswordException extends BadRequestException
{
    #[Pure] public function __construct(string $message = null)
    {
        $message = $message ?: 'Invalid username or password!';

        parent::__construct($message);
    }
}

