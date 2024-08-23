<?php

namespace App\Policies;

use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the Admin can view any models.
     */
    public function viewAny(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Product::permissions()['viewAny'], $permissions)) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the Admin can create models.
     */
    public function create(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Product::permissions()['create'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can update the model.
     */
    public function update(Admin $admin, Product $product, $website): bool
    {
        if ($admin->website_id != $product->website_id) {
            return false;
        }
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Product::permissions()['update'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can delete the model.
     */
    public function delete(Admin $admin, Product $product, $website): bool
    {
        if ($admin->website_id != $product->website_id) {
            return false;
        }
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Product::permissions()['delete'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the Admin can restore the model.
     */
    // public function restore(Admin $admin, Product $product): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the Admin can permanently delete the model.
    //  */
    // public function forceDelete(Admin $admin, Product $product): bool
    // {
    //     //
    // }
}
