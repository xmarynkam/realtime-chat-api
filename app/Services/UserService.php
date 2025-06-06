<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\QueryTaps\HasParticipant;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function getAvailableUsersForChatting(User $user): Collection
    {
        return User::query()
            ->where('users.id', '!=', $user->id)
            ->whereDoesntHave(
                'chats',
                fn ($chat) => $chat->tap(new HasParticipant($user->id))
            )
            ->get();
    }
}
