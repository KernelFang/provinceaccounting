<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated and has the correct type
        if (!Auth::check() || !in_array(Auth::user()->user_type, ['superadmin', 'admin', 'staff'])) {
            // Log the user out
            Auth::logout();

            // Return the custom unauthorized error view with a 403 status code
            return response()->view('errors.error', [
                'error' => 'Unauthorized user type.',
                'status' => 403,
            ], 403);
        }

        // Get the current route name (e.g., 'users.create')
        $routeName = Route::currentRouteName(); // e.g., 'users.create'

        // Get the user's permissions: merged role defaults + user-specific
        $permissions = Auth::user()->mergedPermissions();

        // Extract the module and action from the route (e.g., 'users' and 'create' from 'users.create')
        list($module, $action) = explode('.', $routeName);

        // Check if the user has permissions for the module and action
        if (isset($permissions[$module])) {
            $actions = $permissions[$module];

            // Check if the user has wildcard permission for this module (e.g., 'users' => ['*'])
            if (in_array('*', $actions)) {
                return $next($request); // User has permission for all actions in this module
            }

            // Check if the user has permission for the specific action (e.g., 'users.create')
            if (in_array($action, $actions)) {
                return $next($request); // User has permission for this action
            }
        }

        // If no permission matched, deny access
        abort(403, 'Unauthorized action.');
    }
}
