<?php

namespace App\Enum;

enum SystemEnum: int
{
    case TESTS = 1;
    case ONFLY = 2;

    public function label(): string 
    {
        return match ($this) {
            self::TESTS => 'Test System',
            self::ONFLY => 'Onfly',
        };
    }
}
