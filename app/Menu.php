<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MenuItem;

class Menu extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
      return $this->hasMany(MenuItem::class);
    }
}
