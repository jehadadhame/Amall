<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            // \App\Models\Category::class,
            // \App\Models\Attribute::class,
            \App\Models\Product::class,
            // \App\Models\Option::class,
        ];
        foreach ($models as $model) {
            $model = new $model;
            $permissions = $model->permissions();
            foreach ($permissions as $permission) {

                Permission::create(['name' => $permission, 'description' => $permission]);
            }
        }
    }
}
