<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Player;
use App\User;
use App\Events\PlayerAdded;
use App\Events\GolferEvent;

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

    event(new PlayerAdded($record));

    return $this->successResponse($record);
  }

	public function update(Request $request, $id)
	{
				$data = $request->toArray();
				$player = Player::findOrFail($id);
				$player->update($data);
				$return = $player->save();

        event(new PlayerAdded($player, false));

				return $this->successResponse($player, "Player status updated");

	}

  public function show($id)
  {
      try {
        $player = Player::findOrFail($id);
      } catch (Exception $e){
        return $this->errorResponse('Player Not Found', 400);
      }

      return $this->successResponse($player, "Player Retrieved");
  }

  public function destroy($id)
  {
      $player = Player::findOrFail($id);
      $player->delete();
      event(new GolferEvent($player));

      return $this->successResponse($player, "Player Archived");
  }

  public function clearAll($course_id)
  {
    $players = Player::where('course_id', $course_id)->forceDelete(); //bypass soft deletes
    return $this->successResponse($players, "All Players have been Deleted");
  }



}
