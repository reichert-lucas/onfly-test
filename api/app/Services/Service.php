<?php

namespace App\Services;

use Illuminate\Support\Arr;

abstract class Service
{
    protected static function applyIfInArray(
        array $array,
        string $key,
        callable $callBack,
        bool $onlyNonEmpty = true
    ): void {
        if (!Arr::has($array, $key)) {
            return;
        }

        $value = Arr::get($array, $key);

        if ($onlyNonEmpty && empty($value) && $value !== 0 && $value !== '0') {
            return;
        }

        $callBack($value);
    }
}
