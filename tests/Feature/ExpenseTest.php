<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_view_expenses_list()
    {
        $response = $this->actingAs($this->user)->get(route('expenses.index'));
        $response->assertStatus(200);
        $response->assertViewIs('expenses.index');
    }

    public function test_can_create_expense()
    {
        $expenseData = [
            'amount' => 1000,
            'description' => '食費',
            'expense_date' => now()->format('Y-m-d'),
            'category' => 'food'
        ];

        $response = $this->actingAs($this->user)->post(route('expenses.store'), $expenseData);
        $response->assertRedirect(route('expenses.index'));
        $this->assertDatabaseHas('expenses', $expenseData);
    }

    public function test_can_delete_expense()
    {
        $expense = Expense::factory()->create(['user_id' => $this->user->id]);
        
        $response = $this->actingAs($this->user)->delete(route('expenses.destroy', $expense));
        $response->assertRedirect(route('expenses.index'));
        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }

    public function test_validates_required_fields()
    {
        $response = $this->actingAs($this->user)->post(route('expenses.store'), []);
        $response->assertSessionHasErrors(['amount', 'description', 'expense_date', 'category']);
    }
} 