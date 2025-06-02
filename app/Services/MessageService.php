<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function createMessage(array $attributes): Message
    {
        return Message::create($attributes);
    }

    public function updateMessage(Message $message, array $attributes): Message
    {
        $message->update($attributes);

        return $message->refresh();
    }

    public function deleteMessage(Message $chat): void
    {
        $chat->delete();
    }
}
