<?php

namespace App\Http\Controllers\Website\Admin\Catalog;

use App\Enums\RedisWebsiteProperty;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Jobs\ProductJob;
use App\Models\Category;
use App\Models\Website;
use Auth;
use Illuminate\Http\Request;
use App\Models\product;

class ProductController extends Controller
{
    /**
     * Displaying the Product List.
     * @return \Illuminate\View\View
     */
    public function index($website)
    {
        if (!Auth::guard('admins')->user()->can('viewAny', [Product::class, $website])) {
            abort(403, 'Unauthorized action');
        }
        $i = 0;
        $products = Product::get()->forPage($i, 25);
        return view("website.admin.catalog.product.index", compact(["products", 'website']));
    }

    /**
     * Show the form for creating a new Product.
     * @return \Illuminate\View\View
     */
    public function create($website)
    {
        if (!Auth::guard('admins')->user()->can('create', [Product::class, $website])) {
            abort(403, 'Unauthorized action');
        }
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website),
        );
        $categories = RedisController::hgetall(
            Category::firstKey($website),
            fn() => get_categories_models($website_id),
        );
        return view("website.admin.catalog.product.create", compact('website', 'categories'));
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(Request $request, $website)
    {
        if (!Auth::guard('admins')->user()->can('create', [Product::class, $website])) {
            abort(403, 'Unauthorized action');
        }
        // dd($request->all());
        $data = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'cover' => ['required'],
            'category_id' => ['required'],
            //todo Handling images
            // 'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            // 'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website),
        );
        $data['website_id'] = $website_id;
        $data['admin_id'] = Auth::guard('admins')->user()->id;
        // dd($data);
        Product::create($data);
        return redirect()->route('website.admin.catalog.product.index', ['website' => $website])->with('success', 'product has been created');

    }

    /**
     * Show the form for editing the specified Product.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('website.admin.product.edit', compact('product'));
    }

    /**
     * Update the specified Product in storage.
     */
    public function update(Request $request, string $id)
    {
        // need to learn javascript and more
    }

    /**
     * Remove the specified Product from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();
    }

    public function restore(string $id)
    {
        Product::where('id', $id)->restore();
    }
    public function forceDelete(string $id)
    {
        Product::where('id', $id)->forceDelete();
    }

    public function bulkDelete(array $ids)
    {
        $products = Product::whereIn('id', $ids)->delete();
    }
}
