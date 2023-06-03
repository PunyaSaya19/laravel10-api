<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // for ($i=1; $i < 20; $i++) { 
        //     Products::create([
        //         'name' => 'Product ' . $i,
        //         'slug' => 'product-' . $i,
        //         'description' => fake()->paragraph(),
        //         'price' => Arr::random([20000, 50000, 90000, 100000, 300000, 1000000]),
        //     ]);
        // }

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
