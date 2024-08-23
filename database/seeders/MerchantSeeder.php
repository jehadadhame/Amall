<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::create([
            "name" => "admin",
            "email" => "admin@test.com",
            "phone" => "0123456789",
            "password" => bcrypt("123456"),
        ]);
    }
}
