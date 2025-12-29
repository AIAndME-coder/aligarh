<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionDependencyService;


class RouteNamePermissionsMiddleware
{
    protected $depService;

    public function __construct(PermissionDependencyService $depService)
    {
        $this->depService = $depService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
			throw UnauthorizedException::notLoggedIn();
		}

        $routeName = $request->route()->getName();
        $permission = Permission::where('name', $routeName)->first();
        $ignored = config('permission.ignore_routes', []);

        // Check if route should be ignored
        if (!$permission || in_array($routeName, $ignored)) {
            return $next($request);
        }

        // Get user and check if Developer role
        $user = Auth::user();
        $isDeveloper = $user->hasRole('Developer');

        // Step 1: Check tenant-level permission (skip for Developer)
        if (!$isDeveloper && !$this->depService->isPermissionAllowedForTenant($routeName, $isDeveloper)) {
            return response()->view('errors.403', [
                'message' => __('messages.permission_not_enabled_for_tenant')
            ], 403);
        }

        // Step 2: Check user's role permission
        if (!$user->hasPermissionTo($permission)) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}