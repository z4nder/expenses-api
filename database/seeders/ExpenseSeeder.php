<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Expense::factory(5)
                ->create([
                    'user_id' => $user->id,
                ]);
        });

    }
}
