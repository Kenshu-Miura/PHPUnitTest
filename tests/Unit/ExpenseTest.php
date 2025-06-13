<?php

namespace Tests\Unit;

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

    public function test_expense_has_required_attributes()
    {
        $expense = new Expense();
        
        $this->assertTrue(in_array('amount', $expense->getFillable()));
        $this->assertTrue(in_array('description', $expense->getFillable()));
        $this->assertTrue(in_array('expense_date', $expense->getFillable()));
        $this->assertTrue(in_array('category', $expense->getFillable()));
        $this->assertTrue(in_array('user_id', $expense->getFillable()));
    }

    public function test_expense_amount_is_cast_to_integer()
    {
        $expense = Expense::factory()->create([
            'amount' => '1000',
            'user_id' => $this->user->id
        ]);
        
        $this->assertIsInt($expense->amount);
        $this->assertEquals(1000, $expense->amount);
    }

    public function test_expense_date_is_cast_to_date()
    {
        $date = now()->format('Y-m-d');
        $expense = Expense::factory()->create([
            'expense_date' => $date,
            'user_id' => $this->user->id
        ]);
        
        $this->assertInstanceOf(\Carbon\Carbon::class, $expense->expense_date);
        $this->assertEquals($date, $expense->expense_date->format('Y-m-d'));
    }

    public function test_expense_can_be_created()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create([
            'user_id' => $user->id,
            'amount' => 1000,
            'category' => '食費',
            'description' => 'テスト支出',
            'expense_date' => now()
        ]);

        $this->assertInstanceOf(Expense::class, $expense);
        $this->assertEquals(1000, $expense->amount);
        $this->assertEquals('食費', $expense->category);
    }

    public function test_expense_belongs_to_user()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $expense->user);
        $this->assertEquals($user->id, $expense->user->id);
    }

    public function test_expense_category_must_be_valid()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        Expense::factory()->create(['category' => '無効なカテゴリー']);
    }
} 