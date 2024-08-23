<?php

namespace App\Http\Controllers\Merchant\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use Illuminate\Validation\Rules\Unique;

class WebsiteController extends Controller
{

    /**
     * Summary of create
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view("merchant.website.create");
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            "name" => ["required", "string", "max:255", 'unique:websites'],
            "domain" => ["required", "string", "max:50", 'unique:websites'],
        ]);
        $data['merchant_id'] = \Illuminate\Support\Facades\Auth::guard('merchants')->id();
        Website::create($data);
        return redirect()->route('merchant.dashboard')->with('success', '');
    }

    /**
     * Summary of edit
     * @param int $id
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        // Retrieve the website by its ID
        $website = Website::find($id);

        // Pass the website data to the view
        return view('merchant.website.edit', compact('website'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => ["required", "string", "max:255"],
            "domain" => ["required", "string", "max:50"],
            "Merchant_id" => ["required", "nemuric", ""],
        ]);
        Website::where("id", $id)->update($data);
    }
}
