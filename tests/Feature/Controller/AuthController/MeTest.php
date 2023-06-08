<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should be return auth user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = getJson(route('me'))->assertStatus(200)->json();

    $this->assertEquals($response['id'], $user->id);
    $this->assertEquals($response['name'], $user->name);
    $this->assertEquals($response['email'], $user->email);
});

it('should be return error with unauthenticated', fn () => getJson(route('me'))->assertStatus(401)->assertSee('Unauthenticated'));
