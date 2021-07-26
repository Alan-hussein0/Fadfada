<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class MessageRead
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $user;


    public $chat;

    public $read_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Chat $chat)
    {
        $this->chat=$chat;
        $this->user=$user;
        $this->read_at = Carbon::now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->chat->id);
    }
}
