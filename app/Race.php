<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['start', 'finish'];

    public function getStartAttribute()
    {
      return [
        'lat' => (float) $this->start_latitude,
        'lng' => (float) $this->start_longitude
      ];
    }

    public function getFinishAttribute()
    {
      return [
        'lat' => (float) $this->finish_latitude,
        'lng' => (float) $this->finish_longitude
      ];
    }
}
