<?php

declare(strict_types=1);

namespace App\QueryTaps;

use Illuminate\Database\Eloquent\Builder;

final readonly class HasParticipant
{
    public function __construct(
        private int $participantId,
    ) {}

    public function __invoke(Builder $builder): void
    {
        $builder->whereHas('participants', function (Builder $query) {
            $query->where('user_id', $this->participantId);
        });
    }
}
