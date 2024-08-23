<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            "name" => "Admin",
            "description" => "Admin",
            "website_id" => "1",
        ]);
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            \DB::insert("INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUE ($role->id,$permission->id) ");
        }
    }
}
