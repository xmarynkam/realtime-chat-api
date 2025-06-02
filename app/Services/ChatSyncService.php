<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\MessageSent;
use App\Models\Chat;

class ChatSyncService
{
    public function syncParticipants(Chat $chat, array $participantIds): void
    {
        $chat->participants()->sync($participantIds);
    }

    public function syncMessages(Chat $chat, array $messages): void
    {
        foreach ($messages as $message) {
            $chat->messages()->create($message);

            broadcast(new MessageSent($message))->toOthers();
        }
    }
}
