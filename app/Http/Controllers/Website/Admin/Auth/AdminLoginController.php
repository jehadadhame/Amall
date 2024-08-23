<?php

namespace App\Http\Controllers\Website\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Admin;
use App\Enums\RedisWebsiteProperty;
use App\Models\Website;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{

    /**
     * Summary of showLoginForm
     * @return |\Illuminate\Contracts\View\View
     */
    public function showLoginForm($website)
    {
        return view("website.admin.auth.login", ["website" => $website]);
    }


    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return |\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request, $website)
    {
        $this->validate($request, [
            "email" => ["required", "email"],
            "password" => ["required", "string", "min:4"],
        ]);
        $credentials = $request->only('email', 'password');
        //todo you may need to use 'use' keywords with $website parameter
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        $credentials['website_id'] = $website_id;

        if (Auth::guard('admins')->attempt($credentials)) {
            RedisController::hset(
                Admin::firstKey($website),
                Admin::secondKey(Auth::guard('admins')->user()->id),
                fn() => Auth::guard('admins')->user()
            );
            // dd(['loged in successfuly', $credentials]);
            return redirect()->intended(route('website.admin.dashboard', ['website' => $website]));
        }
        dd(['cant loged in', $credentials]);
        return back()->with('error', 'email or password');
    }


    public function logout($website)
    {
        dd($website);
        Auth::guard('admins')->logout();
        return redirect()->route('website.admin.auth.login', ['website' => $website]);
    }
}
