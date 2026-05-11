<?php

namespace App\Models\Concerns;

use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasPublicationStatus
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PublicationStatus::Published);
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', PublicationStatus::Draft);
    }
}
