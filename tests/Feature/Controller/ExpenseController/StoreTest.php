<?php

use App\Mail\ExpenseCreated;
use App\Models\Expense;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use Symfony\Component\HttpFoundation\Response;

it('should be store expense', function () {
    Mail::fake();

    $user = User::factory()->create();
    Sanctum::actingAs($user);
    $expenses = Expense::factory()->make()->toArray();

    postJson(route('expenses.store'), $expenses)->assertStatus(Response::HTTP_CREATED)->json();

    Mail::assertQueued(ExpenseCreated::class);

    assertDatabaseHas('expenses', $expenses);
});

it('should be not unauthorized if not auth', function () {
    $response = postJson(route('expenses.store'))->assertStatus(Response::HTTP_UNAUTHORIZED)->json();
    expect($response)->toMatchArray(['message' => 'Unauthenticated.']);
});
