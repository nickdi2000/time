<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\Player;

use Illuminate\Console\Command;

class ExpirePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'players:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire All Players that have requested more than an hour ago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expirey = Carbon::now()->subHours(1);

        $players = Player::select('name', 'updated_at')
          ->whereDate('updated_at', '<', $expirey )
          ->where('status_id', '<>', 5);

        $count = $players->count();
        $players->update(['status_id' => 5]);

        echo "Expired $count players older than 1 hour ($expirey)" . PHP_EOL;
    }
}
