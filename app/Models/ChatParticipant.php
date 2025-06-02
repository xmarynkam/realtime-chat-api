<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @package App\Models
 *
 * @mixin Builder
 *
 * @property-read int $id
 * @property int $chat_id
 * @property Chat $chat
 * @property int $user_id
 * @property User $user
 * @property ?CarbonImmutable $created_at
 * @property ?CarbonImmutable $updated_at
 */
class ChatParticipant extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
