<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Convert role integers to match our system
        $allowedRoles = array_map(function($role) {
            switch(strtolower($role)) {
                case 'superadministrador':
                case 'superadmin':
                    return 1;
                case 'administrador':
                case 'admin':
                    return 2;
                case 'usuario':
                case 'user':
                    return 3;
                default:
                    return (int) $role;
            }
        }, $roles);

        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        // Redirect based on user role
        switch ($user->role) {
            case 1: // SuperAdministrador
                return redirect()->route('dashboard.superadmin');
            case 2: // Administrador
                return redirect()->route('dashboard.admin');
            case 3: // Usuario
                return redirect()->route('dashboard.usuario');
            default:
                return redirect()->route('login');
        }
    }
}
