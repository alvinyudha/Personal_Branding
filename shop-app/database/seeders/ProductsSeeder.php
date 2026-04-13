<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = DB::table('categories')->get();
        $productsList = [
            'Laptop' => ['Dell XPS 13', 'MacBook Pro', 'HP Spectre x360', 'Lenovo ThinkPad X1 Carbon', 'Asus ZenBook 14'],
            'Mouse' => ['Logitech MX Master 3', 'Razer DeathAdder V2', 'SteelSeries Rival 600', 'Corsair Dark Core RGB/SE', 'Microsoft Surface Precision Mouse'],
            'Keyboard' => ['Keychron K6', 'Ducky One 2 Mini', 'Razer BlackWidow Elite', 'Corsair K95 RGB Platinum', 'Logitech G Pro X Keyboard'],
            'Headset' => ['Sony WH-1000XM4', 'Bose QuietComfort 35 II', 'Sennheiser Momentum 3 Wireless', 'Jabra Elite 85h', 'SteelSeries Arctis Pro Wireless'],
            'Monitor' => ['Dell UltraSharp U2720Q', 'LG 27UK850-W', 'ASUS ProArt PA278QV', 'BenQ PD3220U', 'Acer Predator X27'],
            'Printer' => ['HP OfficeJet Pro 9015e', 'Canon PIXMA TR8520', 'Epson EcoTank ET-4760', 'Brother HL-L2350DW', 'Samsung Xpress M2020W'],
            'Webcam' => ['Logitech C920S HD Pro Webcam', 'Razer Kiyo Pro Streaming Webcam', 'Microsoft LifeCam HD-3000', 'AverMedia Live Streamer CAM 513', 'Elgato Facecam'],
            'Flashdisk' => ['SanDisk Ultra Flair USB 3.0 Flash Drive 128GB', 'Samsung BAR Plus USB 3.1 Flash Drive 256GB', 'Kingston DataTraveler G4 USB Flash Drive 64GB', 'PNY Turbo Attaché 4 USB Flash Drive 128GB', 'Corsair Flash Voyager GTX USB 3.1 Flash Drive 512GB'],
            'Harddisk External' => ['Western Digital My Passport 4TB External Hard Drive', 'Seagate Backup Plus Slim 2TB External Hard Drive', 'Toshiba Canvio Advance 1TB External Hard Drive', 'LaCie Rugged Mini 2TB External Hard Drive', 'G-Technology G-Drive Mobile SSD R-Series External Hard Drive']
        ];

        for ($i = 1; $i <= 20; $i++) {
            $category = $categories->random();

            DB::table('products')->insert([
                'category_id' => $category->id,
                'product_name' =>  $faker->randomElement($productsList[$category->categories_name]),
                'price' => $faker->numberBetween(100000, 1000000),
                'description' => $faker->sentence(),
                'stok' => $faker->numberBetween(1, 100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
