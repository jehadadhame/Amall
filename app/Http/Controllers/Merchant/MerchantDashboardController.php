<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantDashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware("merchants");
    }
    public function index()
    {
        $websites = \App\Models\Website::all();
        return view('merchant.dashboard', compact('websites'));
    }
    public function gotoWebisteDashboard($website)
    {
        $mer = Auth::guard('merchants')->user();
        // $mer = Auth::user();
        $token = $mer->createToken('RedirectToken')->plainTextToken;
        return redirect()->route('website.admin.dashboard', ['website' => $website, 'token' => $token]);
    }
}
