<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('users')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		$password = Hash::make('admin');
		$now = Carbon::now();
        DB::table('users')->insert([
				'name' => 'admin',
				'email' => 'admin@admin.com',
				'is_active' => true,
				'is_admin' => true,
				'password' => $password,
				'created_at' => $now,
		]);
		
		$password = Hash::make('user1');
		$now = Carbon::now();
        DB::table('users')->insert([
				'name' => 'user1',
				'email' => 'user1@email.com',
				'is_active' => true,
				'is_admin' => false,
				'password' => $password,
				'created_at' => $now,
		]);
    }
}
