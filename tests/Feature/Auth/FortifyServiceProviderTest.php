<?php

namespace Tests\Feature\Auth;

use App\Http\Responses\LoginResponse;
use App\Providers\FortifyServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use Tests\TestCase;

class FortifyServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Laravel\Fortify\FortifyServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
    }

    public function test_login_response_is_bound(): void
    {
        $this->assertInstanceOf(
            LoginResponse::class,
            $this->app->make(LoginResponseContract::class)
        );
    }

    public function test_login_view_is_registered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_register_view_is_registered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function test_forgot_password_view_is_registered(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    public function test_reset_password_view_is_registered(): void
    {
        $response = $this->get('/reset-password/token');
        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    public function test_verify_email_view_is_registered(): void
    {
        $user = \App\Models\User::factory()->unverified()->create();
        $response = $this->actingAs($user)->get('/verify-email');
        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-email');
    }
} 