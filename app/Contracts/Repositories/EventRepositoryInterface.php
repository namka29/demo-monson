<?php

namespace App\Contracts\Repositories;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Event;

    public function firstBySlugOrFail(string $slug): Event;

    public function paginatePublishedByStartsAtDesc(int $perPage): LengthAwarePaginator;

    /** @return Collection<int, Event> */
    public function publishedHomeLatest(int $limit): Collection;
}
