<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::create(['name' => 'Electronics']);
        $fashion     = Category::create(['name' => 'Fashion']);
        $home        = Category::create(['name' => 'Home & Living']);

        Product::create([
            'name' => 'Wireless Earbuds',
            'description' => 'Minimal blue/white earbuds for daily use.',
            'category_id' => $electronics->id,
            'price' => 1299,
            'stock' => 25,
            'is_active' => true,
            'image_path' => null,
        ]);

        Product::create([
            'name' => 'Blue Hoodie',
            'description' => 'Soft hoodie, clean minimalist style.',
            'category_id' => $fashion->id,
            'price' => 899,
            'stock' => 40,
            'is_active' => true,
            'image_path' => null,
        ]);

        Product::create([
            'name' => 'Desk Lamp',
            'description' => 'Simple white desk lamp with warm light.',
            'category_id' => $home->id,
            'price' => 499,
            'stock' => 15,
            'is_active' => true,
            'image_path' => null,
        ]);
    }
}
