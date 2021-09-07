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
		protected $appends = ['position'];

		public function course()
		{
			return $this->belongsTo(Course::class);
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

		protected static function boot()
		{

				parent::boot();
				static::creating(function ($model) {
					if ($model->name == ''){
						$proGolfers = ['Jack Nicklaus', 'Ben Hogan', 'Arnold Palmer', 'Byron Nelson', 'Billy Casper',
						'Walter Hagen', 'Phil Mickelson', 'Cary Middlecoff', 'Tom Watson', 'Gene Sarazen', 'Lloyd Mangrum',
						'Vijay Singh', 'Jimmy Demaret', 'Horton Smith', 'Harry Cooper', 'Gene Littler', 'Lee Trevino',
						'Leo Diegel', 'Paul Runyan', 'Henry Picard', 'Tommy Armour', 'Johnny Miller', 'Macdonald Smith',
						'Dustin Johnson', 'Gary Player', '[d] Jim Barnes', 'Johnny Farrell', 'Raymond Floyd', 'Davis Love III',
						'Happy Gilmour', 'Bugs Bunny', 'Nelly Korda', 'Inbee Park', 'Arnold Palmer', 'Roy McAvoy', 'Shooter McGavin',
						'Tiger Woods', 'Bob Barker'
						];
						$length = sizeOf($proGolfers) - 1;
						$selection = rand(1,$length);
						$randomGolfer = $proGolfers[$selection] . ' #' . rand(5,111);

						$model->name = $randomGolfer;

						$model->color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
					}
				});
		}


}
