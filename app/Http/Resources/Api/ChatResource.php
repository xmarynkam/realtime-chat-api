<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Chat
 */
class ChatResource extends JsonResource
{
    public static $wrap = 'chat';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'creatorId' => $this->creator_id,
            'participants' => ChatParticipantResource::collection($this->whenLoaded('participants')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'createdAt' => $this->created_at,
        ];
    }
}
