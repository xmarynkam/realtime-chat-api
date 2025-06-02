<?php

declare(strict_types=1);

namespace App\Http\Resources\Api;

use App\Models\ChatParticipant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChatParticipant
 */
class ChatParticipantResource extends JsonResource
{
    public static $wrap = 'participant';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
