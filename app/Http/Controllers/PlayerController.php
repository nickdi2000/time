<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Player;
use App\User;

class PlayerController extends Controller
{
  protected $model = Player::class;

  /* get all players by COURSE  */
  public function list($id)
  {
    $players = Player::where('course_id', $id)->get();
    return response()->json($players);

  }


  public function store(Request $request)
  {
    $data = $request->toArray();
    $record = Player::create($data);
		$record['status_id'] = 1; // starts out as active when new player is created

    return $this->successResponse($record);
  }

	public function update(Request $request, $id)
	{
				$data = $request->toArray();
				$course = Player::findOrFail($id);
				$course->update($data);
				$return = $course->save();
				return $this->successResponse($course, "Player status updated");

	}

  public function show($id)
  {
      $player = Player::findOrFail($id);
      return response()->json($player);
  }

  public function destroy($id)
  {
      $player = Player::findOrFail($id);
      $player->delete();
      return $this->successResponse($player, "Player Archived");
  }



}
