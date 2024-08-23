<?php

namespace App\Http\Middleware;

use App\Enums\RedisWebsiteProperty;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Website;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use ILluminate\Support\Facades\Auth;

class WebsiteAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $website = $request->route('website');
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        if (!(Auth::guard('admins')->check())) {
            return redirect()->route('website.admin.auth.loginform', ['website' => $website]);
        }
        $website_idFromAdmin = Auth::guard('admins')->user()->website_id;
        if ($website_idFromAdmin != $website_id) {
            return redirect()->route('website.admin.auth.loginform', ['website' => $website]);
        }
        return $next($request);
    }
}
