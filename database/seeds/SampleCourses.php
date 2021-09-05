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
        ]);
    }
}
