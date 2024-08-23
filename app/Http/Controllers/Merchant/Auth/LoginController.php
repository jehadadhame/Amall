<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Merchant.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::guard('merchants')->attempt($credentials)) {
            return redirect()->route('merchant.dashboard');
        }

        return back()->with('error', 'email or password wrong');

    }

    public function logout(Request $request)
    {
        Auth::guard('merchants')->logout();
        return redirect()->route('merchant.auth.loginform');
    }
}
