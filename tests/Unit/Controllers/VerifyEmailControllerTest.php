<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoke_verifies_email_and_redirects()
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);
        $this->withoutMiddleware(['throttle:6,1']);

        $url = URL::signedRoute('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertRedirect('/dashboard?verified=1');
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_invoke_redirects_when_already_verified()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);
        $this->withoutMiddleware(['throttle:6,1']);

        $url = URL::signedRoute('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $response = $this->get($url);

        $response->assertRedirect('/dashboard?verified=1');
    }
}
