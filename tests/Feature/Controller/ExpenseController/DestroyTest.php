<?php

use App\Models\Expense;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\deleteJson;
use Symfony\Component\HttpFoundation\Response;

it('should be destroy a user expenses', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $user->id]);

    $response = deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_OK)->json();
    expect($response)->toMatchArray(['message' => 'Expense deleted successfully']);
});

it('should be not unauthorized if not auth', function () {
    $user = User::factory()->create();
    $expense = Expense::factory()->create(['user_id' => $user->id]);
    $response = deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_UNAUTHORIZED)->json();
    expect($response)->toMatchArray(['message' => 'Unauthenticated.']);
});

it('should be not unauthorized if not expense owner', function () {
    $userOwner = User::factory()->create();
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expense = Expense::factory()->create(['user_id' => $userOwner->id]);
    $response = deleteJson(route('expenses.destroy', $expense->id))->assertStatus(Response::HTTP_FORBIDDEN)->json();
    expect($response)->toMatchArray(['message' => 'This action is unauthorized.']);
});
