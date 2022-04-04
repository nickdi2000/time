<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Player as User;

class PlayerNotification extends BaseEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $players, $user, $newUser, $game_id;

    protected $broadcastName = "PlayerNotification";

    #this event can be called with no users to refresh the frontend, send game id instead of full user
    public function __construct($user = [], $newUser = false)
    {
        $this->newUser = $newUser;
        $this->user = $user;
        $this->game_id = is_int($user) ? $user : 321;
        $this->players = User::all();

    }

    public function broadcastWith()
    {
      if($this->newUser){
        $this->players->push($this->user);
      }

      $refresh_all = ((array)$this->user && !is_int($this->user)) ? false : true;

      return [
        'players' => $this->players,
        'refresh_all' => $refresh_all
      ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //$game_id = $this->user['game_id'];
        return new Channel("players-$this->game_id");
    }
}
