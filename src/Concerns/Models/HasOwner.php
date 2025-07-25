<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait HasOwner
{
    /**
     * @return MorphTo<Model, $this>
     */
    public function owner(): MorphTo
    {
        return $this->morphTo('owner')->withoutGlobalScopes();
    }

    public function isOwner(?Model $model = null): bool
    {
        $owner = $model ?? auth()->user();

        return every([
            $owner?->getMorphClass() === $this->getAttribute('owner_type'),
            $owner?->getKey() === $this->getAttribute('owner_id'),
        ]);
    }
}
