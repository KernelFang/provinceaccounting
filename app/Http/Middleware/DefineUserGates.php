<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DefineUserGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is authenticated
        if ($user = Auth::user()) {
            // Use merged permissions (role defaults + user-specific)
            $rolePermissions = $user->mergedPermissions();

            // Get the route name (e.g., 'messages.index')
            $routeName = $request->route()->getName();

            // Extract the module from the route name (e.g., 'messages' from 'messages.index')
            $parts = explode('.', $routeName);
            $module = $parts[0]; // Assuming the first part is the module name

            // Check if permissions exist for the module
            if ($module && isset($rolePermissions[$module])) {
                // Define gates for each action in the module
                foreach ($rolePermissions[$module] as $action) {
                    $gateName = "{$module}.{$action}";

                    // Check if the gate already exists, if so skip defining it again
                    if (!Gate::has($gateName)) {
                        Gate::define($gateName, function ($user) use ($rolePermissions, $module, $action) {
                            return in_array($action, $rolePermissions[$module]);
                        });

                        Log::info("Gate created: {$gateName} for user {$user->id}");
                    } else {
                        Log::info("Gate {$gateName} already defined for user {$user->id}");
                    }
                }
            } else {
                Log::warning("No permissions defined for route name: {$routeName} or module: {$module}");
            }
        } else {
            Log::warning("No authenticated user found. Skipping gate definitions.");
        }

        return $next($request);
    }
}
