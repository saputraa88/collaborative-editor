<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CursorMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $position;
    public $documentId;

    public function __construct($position, $documentId)
    {
        $this->position = $position;
        $this->documentId = $documentId;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('document.' . $this->documentId)
        ];
    }

    public function broadcastAs(): string
    {
        return 'CursorMoved';
    }
}