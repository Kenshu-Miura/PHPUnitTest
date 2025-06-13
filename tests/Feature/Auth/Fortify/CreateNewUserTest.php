<?php

namespace Tests\Feature\Auth\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_new_user(): void
    {
        $action = new CreateNewUser();

        $user = $action->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_cannot_create_user_with_existing_email(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $action = new CreateNewUser();

        $this->expectException(ValidationException::class);

        $action->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    }

    public function test_password_must_be_confirmed(): void
    {
        $action = new CreateNewUser();

        $this->expectException(ValidationException::class);

        $action->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ]);
    }
} 