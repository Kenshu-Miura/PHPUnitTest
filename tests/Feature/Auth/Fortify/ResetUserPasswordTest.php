<?php

namespace Tests\Feature\Auth\Fortify;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_reset(): void
    {
        $user = User::factory()->create();
        $action = new ResetUserPassword();

        $action->reset($user, [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_password_must_be_confirmed(): void
    {
        $user = User::factory()->create();
        $action = new ResetUserPassword();

        $this->expectException(ValidationException::class);

        $action->reset($user, [
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);
    }

    public function test_password_must_match_validation_rules(): void
    {
        $user = User::factory()->create();
        $action = new ResetUserPassword();

        $this->expectException(ValidationException::class);

        $action->reset($user, [
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
    }
} 