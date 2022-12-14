<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SongRequest;

class LyricsRequested implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $song, $artist, $gig;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SongRequest $songRequest)
    {
        $this->song = $songRequest->song;
        $this->artist = $songRequest->song->artist;
        $this->gig = $songRequest->gig;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('setlist.gig.'.$this->gig->id);
    }
}
