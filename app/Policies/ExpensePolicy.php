<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    public function show(User $user, Expense $expense)
    {
        return $user->id === $expense->user_id;
    }
}
