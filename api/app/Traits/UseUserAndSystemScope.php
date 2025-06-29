<?php

namespace App\Traits;

use App\Scopes\SystemScope;
use App\Scopes\UserScope;

trait UseUserAndSystemScope
{
    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
        static::addGlobalScope(new SystemScope);
    }
}