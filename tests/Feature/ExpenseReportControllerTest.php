<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_requires_authentication()
    {
        $response = $this->get(route('expenses.report'));
        $response->assertRedirect(route('login'));
    }

    public function test_report_shows_current_month_by_default()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 今月の支出を作成
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 1000,
            'category' => '食費',
            'expense_date' => now()
        ]);

        $response = $this->get(route('expenses.report'));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 1000);
        $response->assertViewHas('yearMonth', now()->format('Y-m'));
    }

    public function test_report_shows_specified_month()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $specifiedMonth = now()->subMonth();
        $yearMonth = $specifiedMonth->format('Y-m');

        // 指定月の支出を作成
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 2000,
            'category' => '交通費',
            'expense_date' => $specifiedMonth
        ]);

        $response = $this->get(route('expenses.report', ['year_month' => $yearMonth]));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 2000);
        $response->assertViewHas('yearMonth', $yearMonth);
    }

    public function test_report_shows_category_totals()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 今月の支出を作成
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 1000,
            'category' => '食費',
            'expense_date' => now()
        ]);
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 2000,
            'category' => '交通費',
            'expense_date' => now()
        ]);

        $response = $this->get(route('expenses.report'));
        $response->assertStatus(200);
        
        $viewData = $response->original->getData();
        $categoryTotals = collect($viewData['categoryTotals']);
        
        $this->assertEquals(1000, $categoryTotals->firstWhere('category', '食費')['total']);
        $this->assertEquals(2000, $categoryTotals->firstWhere('category', '交通費')['total']);
    }

    public function test_report_shows_monthly_totals_for_past_6_months()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 過去6ヶ月分の支出を作成
        for ($i = 0; $i < 6; $i++) {
            Expense::factory()->create([
                'user_id' => $user->id,
                'amount' => 1000 * ($i + 1),
                'expense_date' => now()->subMonths($i)
            ]);
        }

        $response = $this->get(route('expenses.report'));
        $response->assertStatus(200);
        
        $viewData = $response->original->getData();
        $monthlyTotals = collect($viewData['monthlyTotals']);
        
        // 過去6ヶ月分のデータが存在することを確認
        $this->assertCount(6, $monthlyTotals);
        
        // 各月の合計が正しいことを確認
        foreach ($monthlyTotals as $index => $data) {
            $expectedAmount = 1000 * (6 - $index);
            $this->assertEquals($expectedAmount, $data['total']);
        }
    }

    public function test_report_only_shows_own_expenses()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // user1の支出
        Expense::factory()->create([
            'user_id' => $user1->id,
            'amount' => 1000,
            'expense_date' => now()
        ]);

        // user2の支出
        Expense::factory()->create([
            'user_id' => $user2->id,
            'amount' => 2000,
            'expense_date' => now()
        ]);

        $this->actingAs($user1);
        $response = $this->get(route('expenses.report'));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 1000);
    }
} 