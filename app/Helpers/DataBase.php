<?php
use App\Models\Category;

/**
 * Summary of get_website_id
 * @param string $website slug
 * @return int website_id 
 */
function get_website_id($website): int
{
    return \DB::select("SELECT `id` FROM `websites` where `domain` = '$website' ")[0]->id;
}
/**
 * Summary of get_categories
 * @param array|string|null $columns
 * @param int $website_id
 * @return array
 */
function get_categories($website_id, $columns = ['id', 'name']): array
{
    if (gettype($columns) == 'array') {
        $columns = implode(',', $columns);
    }
    $res = \DB::select("SELECT $columns FROM `categories` WHERE `website_id` = $website_id ");
    return $res;
}
function get_categories_models($website_id)
{
    return Category::all();
}


/**
 * Summary of get_role_permissions
 * @param int $role_id
 * @return array
 */
function get_role_permissions($role_id)
{
    $permissions = \DB::table('permissions')
        ->join('roles_permissions', 'roles_permissions.permission_id', '=', 'permissions.id')
        ->where('roles_permissions.role_id', $role_id)
        ->pluck('permissions.name')
        ->toArray();
    return $permissions;

}
