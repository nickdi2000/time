<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Course extends Model
{
    protected $guarded = ['id'];
		protected $tableName = 'courses';
		protected $modelName = 'Course';
		protected $appends = ['validAddress'];

    public function __construct(array $attributes = array())
    {

        $this->setRawAttributes(array(
          'code' => $this->randomCode()
        ), true);
        parent::__construct($attributes);
    }


	public function users()
	{
		return $this->hasMany(User::class);
	}

  public function players()
  {
    return $this->hasMany(Player::class);
  }

	public function getValidAddressAttribute()
	{
		return ($this->longitude && $this->latitude) ? true : false;
	}

  public function randomCode()
    {
      $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      return substr(str_shuffle($str_result),
                       0, 5);
    }
}
