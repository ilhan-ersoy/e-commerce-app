<?php

namespace Database\Seeders;

use App\Models\Product;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++){
            Product::create([
                'name'=>'Laptop-'.$i,
                'slug'=>'laptop-'.$i,
                'details'=>'15 inch , 1 TB SSD, 16 GB RAM',
                'price'=>14999,
                'description'=>'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'
            ]);
        }
    }
}
