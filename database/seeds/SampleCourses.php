<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class SampleCourses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::where('name', 'Southampton Golf & Country Club')
          ->update([
          'code' => 'SOUTH',
          'address' => '400 N Rankin St, Southampton, ON N0H 2L0',
          'longitude' => -81.35237355853343,
          'latitude' => 44.51078892636201,
          "active" => 1, 
        ]);

        Course::updateOrCreate([
          'name' => 'Claremont Lodge',
          'code' => 'arcade'],
          [
          'address' => '6 Arcade Crescent',
          'longitude' => -79.87848425290058,
          'latitude' => 43.24505612916131,
          "active" => 1,
        ]);

        Course::updateOrCreate([
          'name' => 'Glen Moor Meadows',
          'code' => 'glen'],
          [
          'address' => '625 Glen Moor Cres',
          'longitude' => -79.78060366644432,
          'latitude' => 43.35204261017828,
          "active" => 1,
        ]);
    }
}
