<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_reset_password_view()
    {
        $response = $this->get('/reset-password/token123?email=user@example.com');

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
        $response->assertViewHas('request');
    }

    public function test_store_resets_password_successfully()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        // Mock the password reset token
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'user@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_store_fails_with_invalid_token()
    {
        $response = $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => 'user@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }
}
