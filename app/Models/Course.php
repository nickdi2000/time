<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Course extends Model
{
    protected $guarded = ['id'];
		protected $tableName = 'courses';
		protected $modelName = 'Course';
		protected $appends = ['validAddress'];

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function getValidAddressAttribute()
	{
		return ($this->longitude && $this->latitude) ? true : false;
	}


}
