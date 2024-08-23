<?php

namespace App\Http\Controllers\Website\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\CategoryTree;
use App\Enums\RedisWebsiteProperty;
use App\Models\Website;
use Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Website\Admin\RedisController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the category.
     * @param mixed $website
     * @return \Illuminate\View\View
     */
    public function index($website)
    {
        if (!Auth::guard('admins')->user()->can('viewAny', [Category::class, $website])) {
            abort(403, 'Unauthorized action');
        }

        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => $website_id = get_website_id($website)
        );
        $categoriestree = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::category_tree),
            function () use ($website_id) {
                $categories = Category::where("website_id", $website_id)->get();
                $categoriestree = CategoryTree::tree(categories: $categories);
                return $categoriestree;
            }
        );
        $tree = CategoryTree::printTree(website: $website, tree: $categoriestree);
        return view("website.admin.catalog.category.index", compact('tree', 'website'));
    }

    /**
     * Show the form for creating a new category.
     * @return \Illuminate\View\View
     */
    public function create($website)
    {
        // Authorization
        if (!Auth::guard('admins')->user()->can('create', [Category::class, $website])) {
            abort(403, 'action not authorized');

        }
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        $categories = RedisController::hgetall(
            Category::firstKey($website),
            fn() => get_categories_models($website_id)
        );
        return view("website.admin.catalog.category.create", compact("website", "categories"));
    }

    /**
     * Store a newly created category in storage.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $website)
    {
        // Authorization 
        if (!Auth::guard('admins')->user()->can('create', [Category::class, $website])) {
            abort(403, 'action not authorized');
        }
        // todo image handling
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'slug' => ['required', 'string', 'max:20'],
            'parent_id' => ['required', 'numeric'],
            // 'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        $data['cover_path'] = "test";
        $data["admin_id"] = Auth::guard('admins')->user()->id;
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        $data["website_id"] = $website_id;
        Category::create($data);
        return redirect()->route('website.admin.catalog.category.index', ['website' => $website])->with('success', 'categoy has been Added ');
        
        // return redirect()->back()->with('success', 'categoy has been Added ');
    }

    /**
     * Display the specified category.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified category.
     * @return \Illuminate\View\View
     */
    public function edit($website, string $id)
    {
        $category = RedisController::hget(
            Category::firstKey($website),
            Category::secondKey($id),
            fn() => Category::findOrFail($id)->first()
        );
        // Authorization 
        if (!Auth::guard('admins')->user()->can('update', [$category, $website])) {
            abort(403, 'action not authorized');

        }
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        $categories = RedisController::hgetall(
            Category::firstKey($website),
            fn() => get_categories_models($website_id)
        );
        return view('website.admin.catalog.category.edit', compact('website', 'category', 'categories', 'id'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update($website, Request $request, string $id)
    {
        $category = RedisController::hget(
            Category::firstKey($website),
            Category::secondKey($id),
            fn() => Category::findOrFail($id)->first()
        );
        // Authorization 
        if (!Auth::guard('admins')->user()->can('update', [$category, $website])) {
            abort(403, 'action not authorized');

        }
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50'],
            'parent_id' => ['required', 'numeric'],
            // 'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        // dd($data);
        $category->update($data);

        return redirect()->route('website.admin.catalog.category.index', ['website' => $website]);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy($website, string $id)
    {
        $category = RedisController::hget(
            Category::firstKey($website),
            Category::secondKey($id),
            fn() => Category::findOrFail($id)->first()
        );
        if (!Auth::guard('admins')->user()->can('delete', [$category, $website])) {
            abort(403, 'action not authorized');

        }
        // dd($category);
        $category->delete();
        return redirect()->route('website.admin.catalog.category.index', ['website' => $website]);
    }
}
