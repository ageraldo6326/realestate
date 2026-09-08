<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

class RoleOrPermissionOrSuperadminMiddleware extends RoleOrPermissionMiddleware
{
    public function handle($request, Closure $next, $roleOrPermission, $guard = null)
    {
        $user = Auth::guard($guard)->user();

        if ($user && method_exists($user, 'isSuperadmin') && $user->isSuperadmin()) {
            return $next($request);
        }

        return parent::handle($request, $next, $roleOrPermission, $guard);
    }
}
