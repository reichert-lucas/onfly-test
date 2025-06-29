<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getIdNameArray(): array
    {
        return [
            ['id' => $this->value],
            ['name' => $this->label()],
        ];
    }
}