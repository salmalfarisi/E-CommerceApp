<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('products')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
        for($i = 1; $i < 4; $i++)
		{
			DB::table('products')->insert([
				'name' => 'Item ke-'.$i,
				'stock' => $i*10,
				'price' => $i*100,
				'user_id' => 2,
				'is_delete' => false,
				'image' => 'gambar'.$i.'.png',
			]);
		}
    }
}
