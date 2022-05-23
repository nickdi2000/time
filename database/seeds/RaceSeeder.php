<?php

use Illuminate\Database\Seeder;
use App\Race;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Race::updateOrCreate([
              'name' => 'Keddy Race',
              'code' => 'keddy'],
              [
              'start_longitude' => -79.85945315788987,
              'start_latitude' => 43.25080218322437,
              'finish_longitude' => -79.88095089286679,
              'finish_latitude' => 43.24414141085183,
              'active' => 1
            ]);

            Race::updateOrCreate([
              'name' => 'Arcade Racer',
              'code' => 'arcade'],
              [
              'start_longitude' => -79.87827281360286,
              'start_latitude' => 43.24483471043779,
              'finish_longitude' => -79.8792580770503,
              'finish_latitude' => 43.242113366788985,
              'active' => 1
            ]);
    }
}
