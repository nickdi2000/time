<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Player;
use App\User;

class PlayerController extends Controller
{
  protected $model = Player::class;

  public function store(Request $request)
  {
    $data = $request->toArray();
    $record = Player::create($data);
		$record['status_id'] = 1; // starts out as active when new player is created

    return $this->successResponse($record);
  }


	    public function me()
	    {
	        $player = player()->player();
	        return response()->json(compact('player'));
	    }


}
