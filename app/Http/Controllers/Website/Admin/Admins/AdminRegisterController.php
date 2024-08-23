<?php

namespace App\Http\Controllers\Website\Admin\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminRegisterController extends Controller
{

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm($website)
    {
        return view("website.admin.auth.register", compact('website'));
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request, $website)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'role_id' => ['required', 'numeric'],
            'password' => ['required', 'string'],
        ]);
        $website_id = \DB::select("SELECT `id` FROM `websites` where `domain` = '$website' ")[0]->id;
        $data['website_id'] = $website_id;
        $data['password'] = bcrypt($data['password']);
        $admin = Admin::create($data);
        // dd($admin);
        return redirect()->route('website.admin.dashboard', ['website' => $website])->with('success', '');
    }
}
