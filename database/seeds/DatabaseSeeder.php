<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
					$this->insertSampleUser();
         $this->call(CoursesSeeder::class);
    }

		public function insertSampleUser(){

			$user = DB::table('users')->where('email', 'example@email.com');

			if ($user){
				return;
			}

			DB::table('users')->insert([
				[
					'name' => 'John Smith',
					'email' => 'example@email.com',
					'password' => Hash::make('password'),
					'user_type' => 3
				]
			]);
		}
}
