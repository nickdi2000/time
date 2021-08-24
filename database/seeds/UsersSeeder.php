<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        [
          'name' => 'John Smith',
          'email' => 'example@email.com',
          'password' => Hash::make('password'),
          'user_type' => 3,
					'course_id' => 1
        ]
      ]);
    }

}
