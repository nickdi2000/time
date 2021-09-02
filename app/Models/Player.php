<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Player extends Model
{
    protected $fillable = ['latitude', 'longitude'];
		protected $tableName = 'players';
		protected $modelName = 'Player';

    public function __construct(array $attributes = array())
    {

    }


	public function course()
	{
		return $this->belongsTo(Course::class);
	}

}
