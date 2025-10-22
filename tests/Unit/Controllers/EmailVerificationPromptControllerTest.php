<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationPromptControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoke_redirects_when_verified()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $response = $this->get('/verify-email');

        $response->assertRedirect('/dashboard');
    }

    public function test_invoke_returns_verify_email_view_when_unverified()
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);

        $response = $this->get('/verify-email');

        $response->assertStatus(200);
        $response->assertViewIs('auth.verify-email');
    }
}
