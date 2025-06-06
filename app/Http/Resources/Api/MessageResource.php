<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 */
class MessageResource extends JsonResource
{
    public static $wrap = 'message';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'chatId' => $this->chat_id,
            'senderId' => $this->sender_id,
            'receiverId' => $this->receiver_id,
            'message' => $this->message,
            'createdAt' => $this->created_at,
        ];
    }
}
