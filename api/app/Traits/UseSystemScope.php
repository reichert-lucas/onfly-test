<?php

namespace App\Traits;

use App\Scopes\SystemScope;

trait UseSystemScope
{
    protected static function booted()
    {
        static::addGlobalScope(new SystemScope);
    }
}