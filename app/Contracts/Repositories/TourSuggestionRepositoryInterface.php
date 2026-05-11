<?php

namespace App\Contracts\Repositories;

use App\Models\TourSuggestion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TourSuggestionRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): TourSuggestion;

    public function firstBySlugOrFail(string $slug): TourSuggestion;

    public function paginatePublishedByUpdatedAtDesc(int $perPage): LengthAwarePaginator;
}
