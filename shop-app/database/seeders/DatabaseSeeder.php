<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Alvin',
            'email' => 'alvin@gmail.com',
            'password' => '12345678',
        ]);

        $this->call([
            CategoriesSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
