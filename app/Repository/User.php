<?php

namespace App\Repository;


class Users
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

		public function all($orderBy);
		{
				$users = User::orderBy('name')->get();
		}

    public function getCacheKey()
    {

				return self::CACHE_KEY . ".$key";
    }
}
