<?php

namespace App\Repositories;

use App\Contracts\Repositories\TourSuggestionRepositoryInterface;
use App\Models\TourSuggestion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentTourSuggestionRepository implements TourSuggestionRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): TourSuggestion
    {
        return TourSuggestion::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): TourSuggestion
    {
        return TourSuggestion::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedByUpdatedAtDesc(int $perPage): LengthAwarePaginator
    {
        return TourSuggestion::query()->published()->orderByDesc('updated_at')->paginate($perPage);
    }
}
