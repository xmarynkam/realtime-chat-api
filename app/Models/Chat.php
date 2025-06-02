<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ChatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @package App\Models
 *
 * @mixin Builder
 *
 * @property-read int $id
 * @property int $creator_id
 * @property User $creator
 * @property ?CarbonImmutable $created_at
 * @property ?CarbonImmutable $updated_at
 * @property-read Collection<ChatParticipant> $participants
 */
class Chat extends Model
{
    /** @use HasFactory<ChatFactory> */
    use HasFactory;

    protected $fillable = [
        'creator_id',
    ];

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(ChatParticipant::class, 'chat_participants', 'chat_id', 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
