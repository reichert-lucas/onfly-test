<?php

use App\Enum\SystemEnum;
use Illuminate\Support\Facades\Hash;

test('users can\'t change system', function () {
    $user = $this->createUser();

    $response = $this->actingAs($user)->post(route('api.auth.choose-system', [ SystemEnum::TESTS->value ]));
  
    $response->assertUnauthorized();
    expect($user->system_id)->not->toBe(SystemEnum::TESTS->value);
});

test('admin users can\'t change system', function () {
    $user = $this->createUser([
        'is_admin' => true,
    ]);

    $response = $this->actingAs($user)->post(route('api.auth.choose-system', [ SystemEnum::TESTS->value ]));
  
    $response->assertUnauthorized();
    expect($user->system_id)->not->toBe(SystemEnum::TESTS->value);
});

test('super admin users can change system', function () {
    $user = $this->createUser([
        'is_super_admin' => true,
    ]);

    $response = $this->actingAs($user)->post(route('api.auth.choose-system', [ SystemEnum::TESTS->value ]));
  
    $response->assertSuccessful();
    expect($user->system_id)->toBe(SystemEnum::TESTS->value);
});