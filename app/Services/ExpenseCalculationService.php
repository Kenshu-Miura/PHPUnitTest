<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\User;
use Carbon\Carbon;

class ExpenseCalculationService
{
    public function calculateTotalForPeriod(User $user, Carbon $startDate, Carbon $endDate): int
    {
        return $user->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');
    }

    public function calculateTotalByCategory(User $user, Carbon $startDate, Carbon $endDate): array
    {
        return $user->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();
    }

    public function calculateMonthlyAverage(User $user, int $months = 3): float
    {
        $endDate = now();
        $startDate = now()->subMonths($months);

        $total = $this->calculateTotalForPeriod($user, $startDate, $endDate);
        
        return $total / $months;
    }
} 