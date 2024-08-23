<?php

namespace App\Policies;

use App\Enums\RedisWebsiteProperty;
use App\Http\Controllers\Website\Admin\RedisController;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Role;
use App\Models\Website;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );
        if (in_array(Category::permissions()['viewAny'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Category $category): bool
    {

        return true;


    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin, $website): bool
    {
        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()['create'], $permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Category $category, $website): bool
    {
        if ($category->website_id != $admin->website_id)
            return false;

        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()["update"], $permissions)) {
            return true;
        }
        return false;

        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, $category, $website): bool
    {
        $website_id = RedisController::hget(
            Website::firstKey($website),
            Website::secondKey(RedisWebsiteProperty::website_id),
            fn() => get_website_id($website)
        );
        if ($category->website_id != $admin->website_id)
            return false;

        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()["delete"], $permissions)) {
            return true;
        }
        return false;
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Category $category, $website): bool
    {
        if ($category->website_id != $admin->website_id)
            return false;

        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()["restore"], $permissions)) {
            return true;
        }
        return false;
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Category $category, $website): bool
    {
        if ($category->website_id != $admin->website_id)
            return false;

        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()["forceDelete"], $permissions)) {
            return true;
        }
        return false;

        //
    }

    public function bulkDelete(Admin $admin, Category $category, $website): bool
    {
        if ($category->website_id != $admin->website_id)
            return false;

        $role_id = $admin->role_id;
        $permissions = RedisController::hget(
            Role::firstKey($website),
            Role::secondKey($role_id),
            fn() => get_role_permissions($role_id),
        );

        if (in_array(Category::permissions()["bulkDelete"], $permissions)) {
            return true;
        }
        return false;
    }
}
