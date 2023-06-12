<?php

namespace App\Http\Actions;

use App\Models\User;
use Illuminate\Support\Carbon;

class GetExpensesStatus
{
    public static function execute(User $user): array
    {
        return [
            ['label' => 'Ultimos 30 dias', 'value' => self::getTotalExpensesByPeriod($user, 30)],
            ['label' => 'Ultimos 15 dias', 'value' => self::getTotalExpensesByPeriod($user, 15)],
            ['label' => 'Ultimos 7 dias', 'value' => self::getTotalExpensesByPeriod($user, 7)],
        ];
    }

    private static function getTotalExpensesByPeriod(User $user, int $range)
    {
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->subDays($range)->format('Y-m-d');

        $total = $user->expenses()
            ->whereDate('date', '<=', $startDate
            )->whereDate('date', '>=', $endDate)
            ->sum('value');

        return 'R$ '.str_replace('.', ',', (float) $total);
    }
}
