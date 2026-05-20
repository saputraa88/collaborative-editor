<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content;
    public $documentId;

    public function __construct($content, $documentId)
    {
        $this->content = $content;
        $this->documentId = $documentId;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('document.' . $this->documentId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'DocumentUpdated';
    }
}