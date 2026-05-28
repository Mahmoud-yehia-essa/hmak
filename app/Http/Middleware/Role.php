<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If the user is logged in
        if ($user) {
            // Redirect logged-in users from login/register pages

             if ($user->role === 'admin') {
                    return redirect()->route('dashboard'); // admin dashboard route
                }
            else if ($request->is('user/login') || $request->is('user/register')) {
                if ($user->role === 'user') {
                    return redirect()->route('show.user.dashboard');
                }

            }

            // Allow access to other routes (dashboard, etc.)
            return $next($request);
        }

        // If not logged in, protect all routes under this middleware except login and register
        if (!$request->is('user/login') && !$request->is('user/register')) {
            return redirect()->route('show.user.login');
        }

        return $next($request);
    }
}
