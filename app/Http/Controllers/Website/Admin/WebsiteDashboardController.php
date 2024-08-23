<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteDashboardController extends Controller
{
    public function __construct()
    {
    }
    public function index($website)
    {
        return view('website.admin.websiteDashboard', compact('website'));
    }
}
