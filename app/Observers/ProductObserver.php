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
