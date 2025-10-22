<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_changes_password_successfully()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $this->actingAs($user);

        $response = $this->put('/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'password-updated');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_update_fails_with_wrong_current_password()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $this->actingAs($user);

        $response = $this->put('/password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $user->refresh();
        $this->assertTrue(Hash::check('oldpassword', $user->password));
    }
}
