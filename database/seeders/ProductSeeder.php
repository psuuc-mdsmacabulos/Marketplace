<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing users
        $users = User::all();

        // Create 20 products, each associated with a random user
        foreach ($users as $user) {
            Product::factory()->count(2)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}