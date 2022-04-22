<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Menu;
use Carbon\Carbon;

class Course extends Model
{
    protected $guarded = ['id'];
		protected $tableName = 'courses';
		protected $modelName = 'Course';
		protected $appends = ['validAddress', 'publicUrl', 'menu_active'];

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

  public function menu()
  {
    return $this->hasOne(Menu::class);
  }

  public function getMenuActiveAttribute()
	{
		return $this->menu ? $this->menu()->first()->pluck('active')[0] : -1;
	}

	public function getValidAddressAttribute()
	{
		return ($this->longitude && $this->latitude) ? true : false;
	}

	public function getPublicUrlAttribute()
	{
    $url = env('APP_URL');
		return preg_replace("(^https?://)", "", $url ) . '/' . $this->code;
	}
  public function randomCode()
    {
      $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      return substr(str_shuffle($str_result),
                       0, 5);
    }
}
