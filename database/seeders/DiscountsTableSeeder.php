<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            'discount_code' => 'TestDevinweb',
            'percentage_value' => 10 ,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
