<?php

namespace App\Repositories;

use App\Contracts\Repositories\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentEventRepository implements EventRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Event
    {
        return Event::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): Event
    {
        return Event::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedByStartsAtDesc(int $perPage): LengthAwarePaginator
    {
        return Event::query()->published()->orderByDesc('starts_at')->paginate($perPage);
    }

    /** @inheritdoc */
    public function publishedHomeLatest(int $limit): \Illuminate\Database\Eloquent\Collection
    {
        return Event::query()->published()->orderByDesc('starts_at')->limit($limit)->get();
    }
}
