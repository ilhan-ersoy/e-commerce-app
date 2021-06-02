<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code'=>'ABC123',
            'type'=>'fixed',
            'value'=>30,
        ]);

        Coupon::create([
            'code'=>'DEF456',
            'type'=>'percent',
            'percent_off'=>50,
        ]);
    }
}
