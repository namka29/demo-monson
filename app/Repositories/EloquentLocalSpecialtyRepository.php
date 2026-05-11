<?php

namespace App\Repositories;

use App\Contracts\Repositories\LocalSpecialtyRepositoryInterface;
use App\Models\LocalSpecialty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentLocalSpecialtyRepository implements LocalSpecialtyRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): LocalSpecialty
    {
        return LocalSpecialty::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): LocalSpecialty
    {
        return LocalSpecialty::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedFiltered(?string $category, int $perPage): LengthAwarePaginator
    {
        $query = LocalSpecialty::query()->published()->orderByDesc('updated_at');

        if (filled($category)) {
            $query->where('category', $category);
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
