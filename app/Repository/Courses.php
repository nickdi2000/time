<?php

namespace App\Repository;

use App\Models\Course;
use Carbon\Carbon;

class Courses
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

		CONST CACHE_KEY = 'COURSES';

		public function all($orderBy = 'name')
		{
				$key = "all.{$orderBy}";
				$cacheKey = $this->getCacheKey($key);

				return cache()->remember($cacheKey, Carbon::now()->addMinutes(1), function() use($orderBy) {
					return Course::orderBy($orderBy)->get();
				});

		}

			public function list($orderBy)
			{
					$users = Course::orderBy('name')->get();
			}

    public function getCacheKey($key)
    {

				return self::CACHE_KEY . ".$key";
    }
}
