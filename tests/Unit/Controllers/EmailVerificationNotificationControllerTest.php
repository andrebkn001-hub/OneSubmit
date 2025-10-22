<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationNotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_sends_verification_when_unverified()
    {
        Notification::fake();

        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);

        $response = $this->post('/email/verification-notification');

        $response->assertRedirect();
        $response->assertSessionHas('status', 'verification-link-sent');

        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    }

    public function test_store_redirects_when_already_verified()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $response = $this->post('/email/verification-notification');

        $response->assertRedirect('/dashboard');
    }
}
