<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['display_icon', 'is_category'];

    public function subItems()
    {
      return $this->hasMany(MenuItem::class, 'parent_id', 'id', 'menu_items');
    }

    public function getDisplayIconAttribute()
    {
      return $this->attributes['icon'] ? 'mdi-' . $this->attributes['icon'] : 'mdi-food';
    }

    public function getIsCategoryAttribute()
    {
      return count($this->subItems()->get()) > 0 ? 1 : 0;
    }

}
