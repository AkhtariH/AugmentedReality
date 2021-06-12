<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Device;
use App\Models\Sensor;


use Illuminate\Support\Facades\DB;

class UpstreamEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id;
    public $sensors;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $sensors)
    {
        $this->id = $id;
        $this->sensors = $sensors;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('sensor-channel');
    }
    
    /**
     * 
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'UpstreamEvent';
    }
}
