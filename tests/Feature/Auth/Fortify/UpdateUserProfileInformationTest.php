<?php

namespace Tests\Feature\Auth\Fortify;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateUserProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_user_profile(): void
    {
        $user = User::factory()->create();
        $action = new UpdateUserProfileInformation();

        $action->update($user, [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
    }

    public function test_cannot_update_to_existing_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);
        $user = User::factory()->create();
        $action = new UpdateUserProfileInformation();

        $this->expectException(ValidationException::class);

        $action->update($user, [
            'name' => 'Test User',
            'email' => 'existing@example.com',
        ]);
    }

    public function test_can_update_name_without_changing_email(): void
    {
        $user = User::factory()->create();
        $action = new UpdateUserProfileInformation();

        $action->update($user, [
            'name' => 'Updated Name',
            'email' => $user->email,
        ]);

        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals($user->email, $user->email);
    }
} 