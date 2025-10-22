<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_returns_profile_edit_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    public function test_update_updates_profile_successfully()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
    }

    public function test_update_resets_email_verification_when_email_changed()
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $response = $this->patch('/profile', [
            'name' => $user->name,
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    public function test_destroy_deletes_account_and_logs_out()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/profile', [
            'password' => 'password', // Assuming default password
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertGuest();
    }
}
