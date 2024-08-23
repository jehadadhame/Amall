<?php

namespace App\Http\Controllers\Merchant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Merchant;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view("Merchant.auth.register");
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $Merchant = Merchant::create($data);

        Auth::guard('merchants')->login($Merchant);
        if (Auth::guard('merchants')->check()) {
            // dd('Merchant is authenticated');
        } else {
            dd('Merchant is not authenticated');
        }
        return redirect()->route('merchant.dashboard');

    }
}
