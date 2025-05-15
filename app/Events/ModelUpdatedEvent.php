<?php

namespace App\Events;

use App\Models\Employee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ModelUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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


    public function itemCreated(Model $item)

    {

        // Log::info("Item Created Event Fire: ".$item);

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function itemUpdated(Model $item)

    {

        // Log::info("Model Updated Event Fire: ".$item);
        if($item instanceof \App\Models\Employee){
            dd($item);
        }

    }



    /**

     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array

     */

    public function itemDeleted(Model $item)

    {

        // Log::info("Model Deleted Event Fire: ".$item);

    }
}
