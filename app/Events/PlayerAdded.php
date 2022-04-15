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

    public $playerData, $playerExists;

    protected $broadcastName = "PlayerAdded";

    public function __construct($data = null, $playerExists = true)
    {
        $this->playerData = $data;
        $this->playerExists = $playerExists;
    }

    public function broadcastWith()
    {
      return [
        'playerData' => $this->playerData,
        'exists' => $this->playerExists
      ];
    }

    public function broadcastOn()
    {
        return new Channel("players-1"); //TODO make dynamc
    }
}
