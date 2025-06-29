<?php

namespace Database\Seeders;

use App\Enum\TravelOrderStatusEnum;
use App\Models\TravelOrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelOrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        TravelOrderStatus::updateOrCreate(
            ['id' => TravelOrderStatusEnum::REQUESTED->value],
            [
                'name' => TravelOrderStatusEnum::REQUESTED->label(),
                'color' => TravelOrderStatusEnum::REQUESTED->color(),
            ]
        );

        TravelOrderStatus::updateOrCreate(
            ['id' => TravelOrderStatusEnum::APPROVED->value],
            [
                'name' => TravelOrderStatusEnum::APPROVED->label(),
                'color' => TravelOrderStatusEnum::APPROVED->color(),
            ]
        );

        TravelOrderStatus::updateOrCreate(
            ['id' => TravelOrderStatusEnum::CANCELLED->value],
            [
                'name' => TravelOrderStatusEnum::CANCELLED->label(),
                'color' => TravelOrderStatusEnum::CANCELLED->color(),
            ]
        );
    }
}
