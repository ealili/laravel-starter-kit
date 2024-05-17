<?php

namespace App\Exceptions\User;

use App\Exceptions\Generic\DataNotFoundException;
use JetBrains\PhpStorm\Pure;

class UserNotFoundException extends DataNotFoundException
{
    #[Pure] public static function withId(int $id): static
    {
        return new static("User with id '$id' not found.");
    }

    #[Pure] public static function withEmail(string $email): static
    {
        return new static("User with id '$email' not found.");
    }
}
