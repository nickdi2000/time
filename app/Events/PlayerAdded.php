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

    //public $game_id;

    protected $broadcastName = "PlayerAdded";

    public function __construct($data = null)
    {
        //'new_golfer' => 123;
        //$this->game = Game::where('id', $game_id)->first();
    }

    public function broadcastWith()
    {
      return [
        'players' => 'test',
        'refresh_all' => 'test123'
      ];
    }

    public function broadcastOn()
    {
        return new Channel("players-1"); //TODO make dynamc
    }
}
