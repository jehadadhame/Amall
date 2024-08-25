<?php

namespace App\Observers;

use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Product;
use App\Models\Website;
use Illuminate\Support\Facades\Redis;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $website_id = $product->website_id;
        $website = Website::find($website_id)->first()->name;

        RedisController::hset(
            Product::firstKey($website),
            Product::secondKey($product->id),
            fn() => $product,
        );


        // $destinationPath = public_path('images\products');
        // if (!file_exists($destinationPath)) {
        //     mkdir($destinationPath, 0755, true);
        // }
        // $imageName = '';
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '_' . $data['slug'] . '_' . rand(100, 999) . '_' . '.' . $image->getClientOriginalExtension();
        //     $image->move($destinationPath, $imageName);
        // } else {
        //     return back()->with('error', 'can\'t upload images');
        // }

        // $product = new Product();
        // $product->title = $data['name'];
        // $product->slug = $data['slug'];
        // $product->description = $data['description'];
        // $product->price = $data['price'];
        // $product->category_id = $data['admin_id'];
        // $product->category_id = $data['website_id'];
        // $product->category_id = $data['category_id'];
        // $product->image = $imageName;
        // $product->is_new = array_key_exists('is_new', $data) ? $data['is_new'] : 0;
        // $product->is_special = array_key_exists('is_special', $data) ? $data['is_special'] : 0;
        // $product->save();


        // if ($request->hasFile('images')) {
        //     $counter = 0;
        //     foreach ($request->file('images') as $image) {
        //         $name = time() . '_' . $request->slug . '_'
        //             . $counter . '_' . rand(1, 100) . '.' .
        //             $image->getClientOriginalExtension();
        //         $image->move($destinationPath, $name);
        //         $counter++;
        //         $product->images()->create([
        //             'path' => $name,
        //         ]);
        //     }
        // }
        // dispatch(new ProductJob($product->id));

    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $website_id = $product->website_id;
        $website = Website::find($website_id)->first()->name;

        RedisController::hset(
            Product::firstKey($website),
            Product::secondKey($product->id),
            fn() => $product,
        );

    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $website_id = $product->website_id;
        $website = Website::find($website_id)->first()->name;

        Redis::hdell(
            Product::firstKey($website),
            Product::secondKey($product->id)
        );

    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
