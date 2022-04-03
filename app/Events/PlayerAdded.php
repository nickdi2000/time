<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Player;
//use Illuminate\Support\Facades\Log;


class PlayerAdded extends BaseEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //public $game, $game_id;

    protected $broadcastName = "PlayerAdded";

    public function __construct()
    {
        //$this->game_id = $game_id;
        //$this->game = Game::where('id', $game_id)->first();
    }

    public function broadcastWith()
    {
      //$gamePlay = json_encode($this->game->game_play);
      return [
        'playerData' => 'Georgio Cargica!!!'
      ];
    }

    public function broadcastOn()
    {
        return new Channel("players-1"); //TODO make dynamc
    }
}
