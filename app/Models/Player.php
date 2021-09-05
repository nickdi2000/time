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
		protected $appends = ['alias', 'position'];

		public function course()
		{
			return $this->belongsTo(Course::class);
		}

		public function getAliasAttribute(){
			return "Anonymous Golfer #" . rand(5,111);
		}

		public function getPositionAttribute(){
			return array(
				"lat" => (float) $this->attributes['latitude'],
				"lng" => (float) $this->attributes['longitude']
			);
		}

		protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];
}
