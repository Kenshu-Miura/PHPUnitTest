<?php

namespace Tests\Feature\Auth;

use App\Http\Responses\LoginResponse;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LoginResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_response_redirects_to_dashboard(): void
    {
        $user = User::factory()->create();
        $response = new LoginResponse();

        $result = $response->toResponse(request());

        $this->assertEquals(route('dashboard'), $result->getTargetUrl());
    }

    public function test_login_response_redirects_to_intended_url(): void
    {
        $user = User::factory()->create();
        $response = new LoginResponse();

        $intendedUrl = '/intended-url';
        session()->put('url.intended', $intendedUrl);

        $result = $response->toResponse(request());

        $this->assertEquals(url($intendedUrl), $result->getTargetUrl());
    }
} 