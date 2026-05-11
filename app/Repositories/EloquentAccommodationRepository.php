<?php

namespace App\Repositories;

use App\Contracts\Repositories\AccommodationRepositoryInterface;
use App\Models\Accommodation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentAccommodationRepository implements AccommodationRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Accommodation
    {
        return Accommodation::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): Accommodation
    {
        return Accommodation::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedFiltered(?string $type, int $perPage): LengthAwarePaginator
    {
        $query = Accommodation::query()->published()->orderByDesc('updated_at');

        if (filled($type)) {
            $query->where('accommodation_type', $type);
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
