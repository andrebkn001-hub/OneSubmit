<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ConfirmablePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_confirm_password_view()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/confirm-password');

        $response->assertStatus(200);
        $response->assertViewIs('auth.confirm-password');
    }

    public function test_store_confirms_password_and_redirects()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $this->actingAs($user);

        $response = $this->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertTrue(session()->has('auth.password_confirmed_at'));
    }

    public function test_store_invalid_password_throws_validation_exception()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $this->actingAs($user);

        $response = $this->post('/confirm-password', [
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('password');
    }
}
