<?php

namespace App\Policies;

use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Attribute;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class AttributePolicy
{
    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Attribute::permissions()['viewAny'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Attribute $attribute): bool
    {
        //
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Attribute::permissions()['create'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Attribute $attribute, $website): bool
    {
        if ($attribute->website_id != $admin->website_id)
            return false;
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Attribute::permissions()['update'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Attribute $attribute, $website): bool
    {

        if ($attribute->website_id != $admin->website_id)
            return false;
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Attribute::permissions()['update'], $permissions)) {
            return true;
        }
        return false;
    }
}
