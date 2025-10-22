<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private RoleMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new RoleMiddleware();
    }

    public function test_handle_allows_access_for_correct_role()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Auth::login($user);

        $request = Request::create('/admin/dashboard', 'GET');
        $next = function ($request) {
            return response('OK');
        };

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    public function test_handle_denies_access_for_incorrect_role()
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);
        Auth::login($user);

        $request = Request::create('/admin/dashboard', 'GET');
        $next = function ($request) {
            return response('OK');
        };

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertStringContainsString('Anda tidak memiliki izin untuk mengakses halaman ini.', $response->getContent());
    }

    public function test_handle_denies_access_for_unauthenticated_user()
    {
        Auth::logout();

        $request = Request::create('/admin/dashboard', 'GET');
        $next = function ($request) {
            return response('OK');
        };

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertStringContainsString('Silakan login terlebih dahulu untuk mengakses halaman ini.', $response->getContent());
    }

    public function test_handle_denies_access_for_unauthenticated_user_without_view()
    {
        Auth::logout();

        $request = Request::create('/api/admin/dashboard', 'GET');
        $next = function ($request) {
            return response('OK');
        };

        $response = $this->middleware->handle($request, $next, 'admin');

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertStringContainsString('Silakan login terlebih dahulu untuk mengakses halaman ini.', $response->getContent());
    }

    public function test_get_role_label_returns_correct_labels()
    {
        $reflection = new \ReflectionClass($this->middleware);
        $method = $reflection->getMethod('getRoleLabel');
        $method->setAccessible(true);

        $this->assertEquals('Administrator', $method->invoke($this->middleware, 'admin'));
        $this->assertEquals('Dosen KJFD', $method->invoke($this->middleware, 'dosen_kjfd'));
        $this->assertEquals('Mahasiswa', $method->invoke($this->middleware, 'mahasiswa'));
        $this->assertEquals('Jurusan', $method->invoke($this->middleware, 'jurusan'));
        $this->assertEquals('Unknown', $method->invoke($this->middleware, 'unknown'));
    }
}
