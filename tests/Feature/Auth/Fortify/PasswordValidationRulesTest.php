<?php

namespace Tests\Feature\Auth\Fortify;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

class PasswordValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    protected function getRules()
    {
        return (new class {
            use PasswordValidationRules;
            public function get() { return $this->passwordRules(); }
        })->get();
    }

    public function test_password_validation_rules(): void
    {
        $rules = $this->getRules();

        $this->assertIsArray($rules);
        $this->assertContains('required', $rules);
        $this->assertContains('string', $rules);
        $this->assertTrue(
            collect($rules)->contains(function ($rule) {
                return $rule instanceof Password;
            }),
            'Password rule should contain an instance of Illuminate\Validation\Rules\Password'
        );
    }

    public function test_password_validation(): void
    {
        $rules = $this->getRules();

        $validator = Validator::make(['password' => 'short'], ['password' => $rules]);
        $this->assertTrue($validator->fails());

        $validator = Validator::make(['password' => 'validpassword', 'password_confirmation' => 'validpassword'], ['password' => $rules]);
        $this->assertFalse($validator->fails());
    }
} 