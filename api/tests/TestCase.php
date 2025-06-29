<?php

namespace Tests;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    public function createUser(array $data = []): User
    {
        return User::factory()->create($data);
    }

    public function faker(): \Faker\Generator
    {
        return Faker::create();
    }
}
