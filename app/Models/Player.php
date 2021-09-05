<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Player extends Model
{
    // protected $fillable = ['latitude', 'longitude', 'name', 'hole'];
		protected $guarded = ['id'];
		protected $tableName = 'players';
		protected $modelName = 'Player';

		public function course()
		{
			return $this->belongsTo(Course::class);
		}

		protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];
}
