<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_404_for_nonexistent_expense()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('expenses.show', ['expense' => 99999]));
        $response->assertStatus(404);
    }

    public function test_store_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('expenses.store'), [
            'amount' => '', // 必須
            'category' => '無効なカテゴリー', // 無効
            'expense_date' => 'invalid-date', // 不正な日付
        ]);

        $response->assertSessionHasErrors(['amount', 'category', 'expense_date']);
    }

    public function test_destroy_forbidden_for_other_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2);
        $response = $this->delete(route('expenses.destroy', ['expense' => $expense->id]));

        $response->assertStatus(403);
    }
} 