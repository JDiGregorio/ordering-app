<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
              if ($request->expectsJson()) {
                return response()->json(['error' => 'Already authenticated.'], 200);
              }
              
              return redirect(RouteServiceProvider::ADMIN);
            }
        }

        return $next($request);
    }
}