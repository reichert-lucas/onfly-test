<?php

namespace Database\Seeders;

use App\Enum\SystemEnum;
use App\Enum\SystemTypeEnum;
use App\Models\System;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        $systems = [
            [
                'id' => SystemEnum::TESTS->value,
                'name' => SystemEnum::TESTS->label(),
            ],
            [
                'id' => SystemEnum::ONFLY->value,
                'name' => SystemEnum::ONFLY->label(),
            ],
        ];

        foreach ($systems as $system) {
            System::updateOrInsert(
                [
                    'id' => $system['id']
                ],
                [
                    'name' => $system['name'],
                ]
            );
        }
    }
}
