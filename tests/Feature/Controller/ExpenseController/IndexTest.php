<?php

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should be list all user expenses', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expenses = Expense::factory(5)->create(['user_id' => $user->id]);

    $response = getJson(route('expenses.index'))->assertStatus(200)->json();
    $expected = ExpenseResource::collection($expenses);

    expect($response)->toBeArray()->toHaveKey('data')
        ->and($response['data'])
        ->toHaveCount(5)
        ->toMatchArray($expected->jsonSerialize());
});

it('should be not unauthorized if not auth', function () {
    $response = getJson(route('expenses.index'))->assertStatus(401)->json();
    expect($response)->toMatchArray(["message" => "Unauthenticated."]);
});
