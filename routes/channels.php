<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

Broadcast::channel('chat.{chatId}', static function ($user, $chatId) {
    return DB::table('chat_participants')
        ->where('chat_id', $chatId)
        ->where('user_id', $user->id)
        ->exists();
});
