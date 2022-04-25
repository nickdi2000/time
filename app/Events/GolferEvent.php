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


class GolferEvent extends BaseEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playerData, $getGeo;

    protected $broadcastName = "GolferEvent";

    public function __construct($data = null, $getGeo = false)
    {
        $this->playerData = $data;
        $this->getGeo = $getGeo;
      //  $this->playerExists = $playerExists;
    }

    public function broadcastWith()
    {
      return [
        'playerData' => $this->playerData,
        'getGeo' => $this->getGeo
      ];
    }

    public function broadcastOn()
    {
        return new Channel("golfer-" . $this->playerData->id); 
    }
}
