<?php

namespace App\Http\Controllers\Website\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Jobs\ProductJob;
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
    public function create()
    {
        ;
        return view("website.admin.catalog.product.create");
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max255'],
            'slug' => ['required', 'string'],
            'discription' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'admin_id' => ['required', 'numeric'],
            'website_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);


        $destinationPath = public_path('images\products');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $imageName = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $data['slug'] . '_' . rand(100, 999) . '_' . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        } else {
            return back()->with('error', 'can\'t upload images');
        }

        $product = new Product();
        $product->title = $data['name'];
        $product->slug = $data['slug'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $data['admin_id'];
        $product->category_id = $data['website_id'];
        $product->category_id = $data['category_id'];
        $product->image = $imageName;
        $product->is_new = array_key_exists('is_new', $data) ? $data['is_new'] : 0;
        $product->is_special = array_key_exists('is_special', $data) ? $data['is_special'] : 0;
        $product->save();


        if ($request->hasFile('images')) {
            $counter = 0;
            foreach ($request->file('images') as $image) {
                $name = time() . '_' . $request->slug . '_'
                    . $counter . '_' . rand(1, 100) . '.' .
                    $image->getClientOriginalExtension();
                $image->move($destinationPath, $name);
                $counter++;
                $product->images()->create([
                    'path' => $name,
                ]);
            }
        }
        dispatch(new ProductJob($product->id));

        return redirect()->route('website.admin.product.index')->with('success', 'product has been created');

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
