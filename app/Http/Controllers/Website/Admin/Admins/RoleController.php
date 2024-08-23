<?php

namespace App\Http\Controllers\Website\Admin\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Summary of index
     * Display a listing of the Roles.
     * @param mixed $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($website)
    {
        $roles = Role::all();
        // dd($roles);
        return view('website.admin.admin.role.index', compact('website', 'roles'));
    }

    /**
     * Summary of create
     * Show the form for creating a new Roles.
     * @param mixed $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($website)
    {
        $permissions = Permission::all();
        // $groups = [];
        // foreach ($permissions as $permission) {
        //     $gr = explode(',', $permission->group->name);
        //     $groups[$gr[0]][$gr[1]][] = $permission;
        // }
        // dd($groups);
        return view('website.admin.admin.role.create', compact('website', 'permissions'));
    }

    /**
     * Summary of store
     * Store a newly created Roles in storage.
     * @param \Illuminate\Http\Request $request
     * @param mixed $website
     * @return mixed|\Illuminate\Http\RedirectResponse
     * 
     */
    public function store(Request $request, $website)
    {

        $data = $request->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string',
        ]);
        $website_id = \DB::select("SELECT `id` FROM `websites` WHERE `domain` = '$website'")[0]->id;
        $data['website_id'] = $website_id;
        $role = Role::create($data);


        $permissions = $request->except(['name', 'description', '_token']);
        foreach ($permissions as $permission_id => $permission) {
            \DB::insert('INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUE (?,?)', [$role->id, $permission_id]);
        }
        return redirect()->route('website.admin.admins.role.index', ['website' => $website]);
    }

    /**
     * Summary of edit
     * Show the form for editing the specified Roles.
     * @param string $id
     * @param mixed $website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($website, string $id)
    {
        // var_dump($website);
        $permissions = Permission::all();
        // $groups = [];
        // foreach ($permissions as $permission) {
        //     $gr = explode(',', $permission->group->name);
        //     $groups[$gr[0]][$gr[1]][] = $permission;
        // }
        $query = "SELECT `permission_id` FROM `roles_permissions` WHERE `role_id` = '$id'";
        $p = \DB::select($query);
        $per = [];
        foreach ($p as $value) {
            $per[] = $value->permission_id;
        }
        $role = Role::findOrFail($id);
        return view('website.admin.admin.role.edit', compact('role', 'website', 'permissions', 'per'));
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @param mixed $website
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $website, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string',
        ]);
        Role::where('id', $id)->update($data);


        \DB::delete("DELETE FROM `roles_permissions` WHERE `role_id` = '$id' ");
        $permissions = $request->except(['name', 'description', '_token', '_method']);
        // dd($permissions);
        foreach ($permissions as $permission_id => $permission) {
            // dd($permission_id);
            \DB::insert('INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUE (?,?)', [$id, $permission_id]);
        }
        return redirect()->route('website.admin.admins.role.index', ['website' => $website]);
    }

    /**
     * Remove the specified Roles from storage.
     */
    public function destroy($website, string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('website.admin.admins.role.index', ['website' => $website]);
    }
}
