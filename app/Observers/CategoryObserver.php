<?php

namespace App\Observers;

use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Category;
use App\Models\CategoryTree;
use App\Enums\RedisWebsiteProperty;
use App\Models\Website;
use illuminate\Support\Facades\Redis;
class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $website_id = $category->website_id;
        $website = Website::find($website_id)->first()->name;

        RedisController::hset(
            Category::firstKey($website),
            Category::secondKey($category->id),
            fn() => $category,
        );
        RedisController::hset(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::category_tree),
            function () use ($website, $website_id) {
                $categories = RedisController::hgetall(Category::firstKey($website), fn() => get_categories_models($website_id));
                $categoriestree = CategoryTree::tree(categories: $categories);
                return $categoriestree;
            },

        );
    }//done 

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $website_id = $category->website_id;
        $website = Website::find($website_id)->first()->name;

        RedisController::hset(
            Category::firstKey($website),
            Category::secondKey($category->id),
            fn() => $category,
        );
        RedisController::hset(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::category_tree),
            function () use ($website, $website_id) {
                $categories = RedisController::hgetall(Category::firstKey($website), fn() => get_categories_models($website_id));
                $categoriestree = CategoryTree::tree(categories: $categories);
                return $categoriestree;
            },

        );
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $website_id = $category->website_id;
        $website = Website::find($website_id)->first()->name;

        Redis::hdel(
            Category::firstKey($website),
            Category::secondKey($category->id),
        );
        RedisController::hset(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::category_tree),
            function () use ($website, $website_id) {
                $categories = RedisController::hgetall(Category::firstKey($website), fn() => get_categories_models($website_id));
                $categoriestree = CategoryTree::tree(categories: $categories);
                return $categoriestree;
            },

        );
    }

    /**
     * Handle the Category "restored" event.
     */
    // public function restored(Category $category): void
    // {
    //     $website_id = $category->website_id;
    //     $website = Website::find($website_id)->first()->name;

    //     $categories = get_categories($website_id);

    //     RedisController::hset(
    //         "{$website}_categories",
    //         'categories',
    //         $categories,
    //         true,
    //     );
    //     RedisController::hset(
    //         "{$website}_categories",
    //         'tree',
    //         fn() => CategoryTree::tree(categories: $categories),

    //     );
    // }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {

    }
}
