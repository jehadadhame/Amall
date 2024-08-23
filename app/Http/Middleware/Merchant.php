<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Merchant
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd(Auth::guard('merchants')->check());
        if (!Auth::guard('merchants')->check()) {
            return redirect()->route('merchant.auth.loginform'); // Redirect to the Merchant login page
        }

        return $next($request);
    }
}