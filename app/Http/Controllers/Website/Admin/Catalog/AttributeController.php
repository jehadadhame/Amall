<?php
namespace App\Http\Controllers\Website\Admin\Catalog;

use App\Enums\AttributeType;
use App\Enums\RedisWebsiteProperty;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Website;
use Auth;
use Carbon\Traits\Options;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Displaying the Attribute List.
     * @param $website 
     * @return \Illuminate\View\View
     * return view of Attribute so you can make CRUD if you authoriazed
     */
    public function index($website)
    {

        if (!Auth::guard('admins')->user()->can('viewAny', [Attribute::class, $website])) {
            abort(403, 'Unauthorized action');
        }

        $website_id = \DB::select("SELECT `id` FROM `websites` where `domain` = '$website' ")[0]->id;
        $attributes = Attribute::where('website_id', '=', $website_id)->get();
        $trashs = Attribute::onlyTrashed()->where('website_id', '=', $website_id)->get();
        return view("website.admin.catalog.attribute.index", compact("attributes", 'website', 'trashs'));
    }

    /**
     * Show the form for creating a new Attribute.
     * @param mixed $website
     * @return \Illuminate\View\View
     * create page 
     */
    public function create($website)
    {
        if (!Auth::guard('admins')->user()->can('create', [Attribute::class, $website])) {
            abort(403, 'Unauthorized action');
        }

        $types = array_column(AttributeType::cases(), 'value');
        return view("website.admin.catalog.attribute.create", compact("website", 'types'));
    }

    /**
     * Store a newly created Attribute in storage.
     * if you authoraized
     * @param \Illuminate\Http\Request $request
     * @param mixed $website
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $website)
    {
        if (!Auth::guard('admins')->user()->can('create', [Attribute::class, $website])) {
            abort(403, 'Unauthorized action');
        }
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string'],

            'option_name.*' => ['required', 'string'],
            //neet to update 'unique:options' 
        ]);

        $data = $request->only('name', 'description', 'type');

        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website),
        );
        $data['website_id'] = $website_id;
        $data['admin_id'] = Auth::guard('admins')->user()->id;
        $attribute = Attribute::create($data);

        for ($i = 0; $i < sizeof($request->option_name); $i++) {
            \DB::insert("INSERT INTO `options`( `name`, `attribute_id`, `created_at`, `updated_at`) VALUES
             ( '{$request->option_name[$i]}', '{$request->option_slug[$i]}', '{$attribute->id}',now(),now() )");
        }
        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'attribute has been created');

    }

    /**
     * Show the form for editing the specified Attribute.
     * @param mixed $website
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($website, string $id)
    {
        $attribute = Attribute::find($id);
        $options = $attribute->options->all();

        if (!Auth::guard('admins')->user()->can('update', [$attribute, $website])) {
            abort(403, 'Unauthorized action');
        }
        return view('website.admin.catalog.attribute.edit', compact('attribute', 'options', 'website'));
    }

    /**
     *  Update the specified Attribute in storage.
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $website, string $id)
    {
        $attribute = Attribute::find($id);
        if (!Auth::guard('admins')->user()->can('update', [$attribute, $website])) {
            abort(403, 'Unauthorized action');
        }
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'option_name.*' => ['required', 'string'],
        ]);
        Attribute::where('id', $id)->update($request->only('name', 'description'));
        Option::where('attribute_id', $id)->delete();

        for ($i = 0; $i < sizeof($request->option_name); $i++) {
            Option::create([
                'name' => $request->option_name[$i],
                'attribute_id' => $id
            ]);
        }

        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'attribute has been created');

    }


    /**
     * Remove the specified Attribute from storage.
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($website, string $id)
    {
        Attribute::where('id', $id)->delete();
        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'success');
    }



    public function restore($website, $id)
    {
        // dd($id);
        Attribute::where('id', $id)->restore();
        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'success');

    }
    public function forceDelete($website, $id)
    {
        Attribute::where('id', $id)->forceDelete();
        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'success');

    }

    public function bulkDelete($website, array $ids)
    {
        Attribute::whereIn('id', $ids)->delete();
        return redirect()->route('website.admin.catalog.attribute.index', ['website' => $website])->with('success', 'success');

    }
}
