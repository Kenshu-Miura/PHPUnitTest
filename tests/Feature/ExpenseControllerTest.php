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

    public function test_can_view_expense_edit_page()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get(route('expenses.edit', ['expense' => $expense->id]));
        $response->assertStatus(200);
        $response->assertViewIs('expenses.edit');
        $response->assertViewHas('expense', $expense);
        $response->assertViewHas('categories');
    }

    public function test_cannot_edit_other_users_expense()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2);
        $response = $this->get(route('expenses.edit', ['expense' => $expense->id]));
        $response->assertStatus(403);
    }

    public function test_can_update_expense()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $updateData = [
            'amount' => 2000,
            'category' => '交通費',
            'description' => '更新された説明',
            'expense_date' => now()->format('Y-m-d')
        ];

        $response = $this->put(route('expenses.update', ['expense' => $expense->id]), $updateData);
        $response->assertRedirect(route('expenses.index'));
        
        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'amount' => $updateData['amount'],
            'category' => $updateData['category'],
            'description' => $updateData['description']
        ]);
    }

    public function test_cannot_update_other_users_expense()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2);
        $response = $this->put(route('expenses.update', ['expense' => $expense->id]), [
            'amount' => 2000,
            'category' => '交通費',
            'description' => '更新された説明',
            'expense_date' => now()->format('Y-m-d')
        ]);

        $response->assertStatus(403);
    }

    public function test_can_view_expense_details()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get(route('expenses.show', ['expense' => $expense->id]));
        $response->assertStatus(200);
        $response->assertViewIs('expenses.show');
        $response->assertViewHas('expense', $expense);
    }

    public function test_cannot_view_other_users_expense_details()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2);
        $response = $this->get(route('expenses.show', ['expense' => $expense->id]));
        $response->assertStatus(403);
    }

    public function test_can_view_expenses_list()
    {
        $user = User::factory()->create();
        $expenses = Expense::factory()->count(3)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get(route('expenses.index'));
        $response->assertStatus(200);
        $response->assertViewIs('expenses.index');
        $response->assertViewHas('expenses');
        $response->assertViewHas('categories');
    }

    public function test_expenses_list_only_shows_own_expenses()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        // user1の支出
        Expense::factory()->count(2)->create(['user_id' => $user1->id]);
        // user2の支出
        Expense::factory()->count(3)->create(['user_id' => $user2->id]);

        $this->actingAs($user1);
        $response = $this->get(route('expenses.index'));
        
        $viewData = $response->original->getData();
        $this->assertCount(2, $viewData['expenses']);
    }
} 