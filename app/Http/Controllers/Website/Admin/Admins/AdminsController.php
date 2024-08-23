<?php

namespace App\Http\Controllers\Website\Admin\Admins;

use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
// use App\Models\Admin;

class AdminsController extends Controller
{

    public function index($website)
    {
        return view("website.admin.admin.index", ["website" => $website]);
    }
}