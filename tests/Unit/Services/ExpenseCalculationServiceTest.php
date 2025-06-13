<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\Expense;
use App\Services\ExpenseCalculationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseCalculationServiceTest extends TestCase
{
    use RefreshDatabase;

    private ExpenseCalculationService $service;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ExpenseCalculationService();
        $this->user = User::factory()->create();
    }

    public function test_calculates_total_for_period()
    {
        // テストデータの作成
        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 1000,
            'expense_date' => now()
        ]);
        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 2000,
            'expense_date' => now()
        ]);

        $total = $this->service->calculateTotalForPeriod(
            $this->user,
            now()->startOfDay(),
            now()->endOfDay()
        );

        $this->assertEquals(3000, $total);
    }

    public function test_calculates_total_by_category()
    {
        // テストデータの作成
        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 1000,
            'category' => '食費',
            'expense_date' => now()
        ]);
        Expense::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 2000,
            'category' => '交通費',
            'expense_date' => now()
        ]);

        $totals = $this->service->calculateTotalByCategory(
            $this->user,
            now()->startOfDay(),
            now()->endOfDay()
        );

        $this->assertEquals(1000, $totals['食費']);
        $this->assertEquals(2000, $totals['交通費']);
    }

    public function test_calculates_monthly_average()
    {
        // 過去3ヶ月分のテストデータを作成
        $now = now();
        for ($i = 0; $i < 3; $i++) {
            Expense::factory()->create([
                'user_id' => $this->user->id,
                'amount' => 3000,
                'expense_date' => $now->copy()->subMonths($i)
            ]);
        }

        $average = $this->service->calculateMonthlyAverage($this->user);

        $this->assertEquals(3000.0, $average);
    }

    public function test_returns_zero_for_no_expenses()
    {
        $total = $this->service->calculateTotalForPeriod(
            $this->user,
            now()->startOfDay(),
            now()->endOfDay()
        );

        $this->assertEquals(0, $total);
    }
} 