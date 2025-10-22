<?php

namespace Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_forgot_password_view()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    public function test_store_sends_reset_link_successfully()
    {
        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturn(Password::RESET_LINK_SENT);

        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
    }

    public function test_store_fails_with_invalid_email()
    {
        $response = $this->post('/forgot-password', [
            'email' => 'invalid-email',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }
}
