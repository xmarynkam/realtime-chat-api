<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Collection;

class ChatService
{
    public function getChats(): Collection
    {
        return Chat::query()
            ->with(['participants', 'messages'])
            ->whereHas(
                'participants',
                fn ($participant) => $participant->where('user_id', auth()->id())
            )
            ->get();
    }

    public function createChat(): Chat
    {
        return Chat::create([
            'user_id' => auth()->id(),
        ]);
    }

    public function deleteChat(Chat $chat): void
    {
        $chat->delete();
    }
}
