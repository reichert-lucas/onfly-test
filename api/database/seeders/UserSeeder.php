<?php

namespace Database\Seeders;

use App\Enum\SystemEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create([
            'system_id' => SystemEnum::TESTS->value
        ]);

        User::updateOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name' => 'Super Admin',
                'is_super_admin' => true,
                'system_id' => SystemEnum::TESTS->value,
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@admin.com'],
            [
                'name' => 'Test Admin',
                'is_admin' => true,
                'system_id' => SystemEnum::TESTS->value,
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@user.com'],
            [
                'name' => 'Test User',
                'is_admin' => false,
                'system_id' => SystemEnum::TESTS->value,
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@onfly.com'],
            [
                'name' => 'Test Onfly',
                'is_admin' => false,
                'system_id' => SystemEnum::ONFLY->value,
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test_admin@onfly.com'],
            [
                'name' => 'Test Admin Onfly',
                'is_admin' => true,
                'system_id' => SystemEnum::ONFLY->value,    
                'password' => Hash::make(env('DEFAULT_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );
    }
}
