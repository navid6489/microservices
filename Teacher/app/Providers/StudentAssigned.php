<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use DB;

class StudentAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $studid;
  
    public $tname;
    public $tid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id,$assignedteachername,$assignedteacherid)
    {
        $this->studid = $id;
            $this->tid = $assignedteacherid;
            $this->tname = $assignedteachername;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
