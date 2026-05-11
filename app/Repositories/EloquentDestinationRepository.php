<?php

namespace App\Repositories;

use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Models\Destination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentDestinationRepository implements DestinationRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Destination
    {
        return Destination::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): Destination
    {
        return Destination::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedByName(int $perPage): LengthAwarePaginator
    {
        return Destination::query()->published()->orderBy('name')->paginate($perPage);
    }

    /** @inheritdoc */
    public function publishedHomeFeatured(int $limit): \Illuminate\Database\Eloquent\Collection
    {
        return Destination::query()->published()->orderBy('name')->limit($limit)->get();
    }
}
