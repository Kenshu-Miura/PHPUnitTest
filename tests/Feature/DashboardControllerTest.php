<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_shows_monthly_total()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 今月の支出を作成
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 1000,
            'expense_date' => now()
        ]);
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 2000,
            'expense_date' => now()
        ]);

        // 先月の支出を作成（表示されないことを確認するため）
        Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 5000,
            'expense_date' => now()->subMonth()
        ]);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 3000);
    }

    public function test_dashboard_shows_zero_when_no_expenses()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 0);
    }

    public function test_dashboard_only_shows_own_expenses()
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
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewHas('monthlyTotal', 1000);
    }
} 