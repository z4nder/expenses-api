<?php

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;

it('should be show a user expenses', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $user->id]);

    $response = getJson(route('expenses.show',  $expense->id))->assertStatus(Response::HTTP_OK)->json();
    $expected = new ExpenseResource($expense);

    expect($response)->toBeArray()->toHaveKey('data')
        ->and($response['data'])
        ->toMatchArray($expected->jsonSerialize());
});

it('should be not unauthorized if not auth', function () {
    $user = User::factory()->create();
    $expense = Expense::factory()->create(['user_id' => $user->id]);
    $response =getJson(route('expenses.show',  $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED)->json();
    expect($response)->toMatchArray(["message" => "Unauthenticated."]);
});

it('should be not unauthorized if not expense owner', function () {
    $userOwner = User::factory()->create();
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $userOwner->id]);
    $response =getJson(route('expenses.show',  $expense->id))->assertStatus(Response::HTTP_FORBIDDEN)->json();
    expect($response)->toMatchArray(["message" => "This action is unauthorized."]);
});
