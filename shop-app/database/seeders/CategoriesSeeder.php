<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['categories_name' => 'Laptop'],
            ['categories_name' => 'Mouse'],
            ['categories_name' => 'Keyboard'],
            ['categories_name' => 'Headset'],
            ['categories_name' => 'Monitor'],
            ['categories_name' => 'Printer'],
            ['categories_name' => 'Webcam'],
            ['categories_name' => 'Flashdisk'],
            ['categories_name' => 'Harddisk External']
        ]);
    }
}