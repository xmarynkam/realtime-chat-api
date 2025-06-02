<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ChatDeleted implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(public Chat $chat) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->chat->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat.deleted';
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chat->id,
        ];
    }
}
