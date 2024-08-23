<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            "name" => "admin",
            "email" => "admin@demo.com",
            "phone" => "012345678",
            "password" => password_hash("123456", PASSWORD_DEFAULT),
            "website_id" => "1",
            "role_id" => "1",
        ]);
    }
}
