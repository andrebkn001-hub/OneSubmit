<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return SymfonyResponse
     */
    public function handle(Request $request, Closure $next, string $role): SymfonyResponse
    {
        if (!auth()->check()) {
            Log::warning('Unauthorized access attempt - user not authenticated', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
            ]);

            return response('Silakan login terlebih dahulu untuk mengakses halaman ini.', 403);
        }

        $user = auth()->user();

        if ($user->role !== $role) {
            Log::warning('Access denied - insufficient role permissions', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_role' => $role,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

            return response('Anda tidak memiliki izin untuk mengakses halaman ini.', 403);
        }

        return $next($request);
    }

    /**
     * Get human readable role label.
     */
    private function getRoleLabel(string $role): string
    {
        return match($role) {
            'admin' => 'Administrator',
            'dosen_kjfd' => 'Dosen KJFD',
            'mahasiswa' => 'Mahasiswa',
            'jurusan' => 'Jurusan',
            default => ucfirst($role),
        };
    }
}
