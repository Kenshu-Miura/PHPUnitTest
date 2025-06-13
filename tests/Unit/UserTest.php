<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('テストユーザー', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    public function test_user_can_have_expenses()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->expenses->contains($expense));
        $this->assertEquals(1, $user->expenses->count());
    }

    public function test_user_email_must_be_unique()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        User::factory()->create(['email' => 'test@example.com']);
    }

    public function test_user_password_is_hashed()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => $password]);

        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(password_verify($password, $user->password));
    }
} 