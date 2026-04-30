<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnforceSuperadminPasswordRotation
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    if (!(bool) config('security.enforce_superadmin_password_rotation', true)) {
      return $next($request);
    }

    /** @var User|null $user */
    $user = Auth::user();
    if (!$user || !$user->isConfiguredSuperadmin() || !$user->usesBootstrapSuperadminPassword()) {
      return $next($request);
    }

    $routeName = (string) optional($request->route())->getName();
    $allowedRoutes = [
      'admin.superadmin.password.edit',
      'admin.superadmin.password.update',
      'logout',
      'logoutmenulateral',
    ];

    if (in_array($routeName, $allowedRoutes, true)) {
      return $next($request);
    }

    return redirect()
      ->route('admin.superadmin.password.edit')
      ->with('warning', 'Debes cambiar la clave inicial del superadmin antes de continuar.');
  }
}
