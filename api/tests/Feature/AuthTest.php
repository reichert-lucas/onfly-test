<?php

use App\Enum\SystemEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;

test('user can get token and user information with right password', function () {
    $faker = $this->faker();
    $email = $faker->email;
    $password = $faker->password;
    $this->createUser([
        'email' => $email,
        'system_id' => SystemEnum::TESTS->value,
        'password' => Hash::make($password)
    ]);

    $response = $this->post(route('api.auth.login', [
        'email' => $email,
        'password' => $password,
    ]));
  
    $response->assertSuccessful();
    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('token')
                ->has('user')
    );
});

test('user cannot get token and user information with wrong password', function () {
    $faker = $this->faker();
    $email = $faker->email;
    $password = $faker->password;
    $this->createUser([
        'email' => $email,
        'system_id' => SystemEnum::TESTS->value,
        'password' => Hash::make($password)
    ]);

    $response = $this->post(route('api.auth.login', [
        'email' => $email,
        'password' => $password . 'wrong',
    ]));
  
    $response->assertUnauthorized();
    $response->assertJson(fn (AssertableJson $json) =>
        $json->has('message')
    );
});
