<?php

namespace App\Http\Controllers;

use App\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    protected $model = MenuItem::class;

    public function store(Request $request)
    {
      $data = $request->toArray();

      $data['icon'] = $this->getIcon($data['title']);

      $record = MenuItem::create($data);
      return $this->successResponse($record);
    }

    public function destroy($id)
    {
      $subItems = MenuItem::where('parent_id', $id);
      $subItems->delete();

      $record = MenuItem::findOrFail($id);
      $record->delete();

      return $this->successResponse($record);
    }

    # Generate an icon based on what the user typed (guessing) - at this point we aren't allowing them to chang eit
    private function getIcon($title)
    {
      $iconList = [
        'beer' => 'beer beers alcohol liquor wine coolers',
        'food' => 'food snacks chips candy snack burger burgers hotdogs fries',
        'cup' => 'drinks water juice pop soda ice tea coffee orange iced cranberry',
        'food-apple' => 'health apple fruit banana healthy salad light lite fruits granola bar almond nature natural',
        'blender' => 'smoothie milkshake shake smoothies smoothy'
      ];

      $final_icon = 'food';

      $title = explode(' ', $title)[0];

      foreach ($iconList as $key=>$icon){
        if ( str_contains($icon, strtolower($title))){
          $final_icon = $key;
        }
      }
      return $final_icon;
    }
}
