<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::create([
            'name' => "root",
            'slug' => "root",
            'cover_path' => "root",
            'website_id' => "1",
            'admin_id' => "1",
        ]);
    }
}