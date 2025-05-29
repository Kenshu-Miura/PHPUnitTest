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
} 