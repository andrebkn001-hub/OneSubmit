<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticatedSessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_login_view()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_store_authenticates_and_redirects_based_on_role()
    {
        $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
        $jurusan = User::factory()->create(['role' => 'ketua_jurusan', 'email' => 'jurusan@example.com', 'password' => bcrypt('password')]);
        $kjfd = User::factory()->create(['role' => 'ketua_kjfd', 'email' => 'kjfd@example.com', 'password' => bcrypt('password')]);
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa', 'email' => 'mahasiswa@example.com', 'password' => bcrypt('password')]);

        // Test admin redirect
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);

        Auth::logout();

        // Test jurusan redirect
        $response = $this->post('/login', [
            'email' => 'jurusan@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/jurusan/dashboard');
        $this->assertAuthenticatedAs($jurusan);

        Auth::logout();

        // Test kjfd redirect
        $response = $this->post('/login', [
            'email' => 'kjfd@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/kjfd/dashboard');
        $this->assertAuthenticatedAs($kjfd);

        Auth::logout();

        // Test mahasiswa redirect
        $response = $this->post('/login', [
            'email' => 'mahasiswa@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/mahasiswa/dashboard');
        $this->assertAuthenticatedAs($mahasiswa);
    }

    public function test_store_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_destroy_logs_out_and_redirects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
