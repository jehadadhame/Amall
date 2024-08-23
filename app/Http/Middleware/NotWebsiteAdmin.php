<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use ILluminate\Support\Facades\Auth;

class NotWebsiteAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     */
    public function handle(Request $request, Closure $next): Response
    {
        $website = $request->route("website");
        // dd($request->url());
        if (Auth::guard('admins')->check() || Auth::guard('merchants')->check()) {
            return redirect()->route('website.admin.dashboard', ['website' => $website]);
        }
        return $next($request);
    }
}
