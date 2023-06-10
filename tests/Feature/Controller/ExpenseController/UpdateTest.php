<?php

use App\Models\Expense;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;
use Symfony\Component\HttpFoundation\Response;

it('should be update expense', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $user->id]);
    $data = Expense::factory()->make()->toArray();

    putJson(route('expenses.update', $expense->id), $data)->assertStatus(Response::HTTP_OK)->json();

    assertDatabaseHas('expenses', $data);
});

it('should be not unauthorized if not auth', function () {
    $user = User::factory()->create();
    $expense = Expense::factory()->create(['user_id' => $user->id]);
    $response = putJson(route('expenses.update', $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED)->json();
    expect($response)->toMatchArray(['message' => 'Unauthenticated.']);
});

it('should be not unauthorized if not expense owner', function () {
    $userOwner = User::factory()->create();
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $userOwner->id]);
    $data = Expense::factory()->make()->toArray();
    $response = putJson(route('expenses.update', $expense->id), $data)->assertStatus(Response::HTTP_FORBIDDEN)->json();
    expect($response)->toMatchArray(['message' => 'This action is unauthorized.']);
});
