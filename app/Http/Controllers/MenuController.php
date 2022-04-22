<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function createOrUpdate(Request $request)
    {
        $data = $request->toArray();

        $menu = Menu::where('course_id', $data['course_id'])->first();

        if($menu){
          $menu->update($data);
          $return = Menu::where('id', $menu->id)->with('items')->first();
          return $this->successResponse($return, "Menu Successfully Updated");
        }
        else {
          $rec = Menu::create(['course_id' => $data['course_id']]);
          $rec->save();
          $this->createSeedItems($rec->id);
          $newMenu = Menu::where('id', $rec->id)->with('items')->first();
          return $this->successResponse($newMenu, "Menu Created with default items");
        }

    }


    public function store(Request $request)
    {
        //
    }

    protected function createSeedItems($menu_id)
    {
      return MenuItem::insert([
        [
          'menu_id' => $menu_id,
          'title' => 'Beer',
          'icon' => 'beer'
        ],
        [
          'menu_id' => $menu_id,
          'title' => 'Snacks',
          'icon' => 'food'
        ],
        [
          'menu_id' => $menu_id,
          'title' => 'Drinks (non-alc)',
          'icon' => 'cup'
        ]
      ]);

    }

    public function menuByCourse(Request $request, $course_id)
    {
        $data = $request->toArray();
        $menu = Menu::where('course_id', $course_id)->with('items')->first();

        return $this->successResponse($menu, "Got Menu");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

}
