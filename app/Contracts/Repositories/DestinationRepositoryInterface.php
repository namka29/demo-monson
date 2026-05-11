<?php

namespace App\Contracts\Repositories;

use App\Models\Destination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface DestinationRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Destination;

    public function firstBySlugOrFail(string $slug): Destination;

    public function paginatePublishedByName(int $perPage): LengthAwarePaginator;

    /** @return Collection<int, Destination> */
    public function publishedHomeFeatured(int $limit): Collection;
}
