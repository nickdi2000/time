<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      User::whereIn('email', ['example@email.com', 'freddy'])->delete();

      DB::table('users')->insert([
        [
          'name' => 'John Smith',
          'email' => 'example@email.com',
          'password' => Hash::make('password'),
          'user_type' => 3,
					'course_id' => 1,
          'golf_course' => 'ABC Meadows'
        ],
        [
          'name' => 'Freddy Super Admin',
          'email' => 'freddy',
          'password' => Hash::make('floyd'),
          'user_type' => 3,
					'course_id' => 570,
          'golf_course' => 'Southampton Golf & Country Club'
        ]
      ]);
    }

}
