<?php

namespace App\Contracts\Repositories;

use App\Models\Accommodation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccommodationRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Accommodation;

    public function firstBySlugOrFail(string $slug): Accommodation;

    public function paginatePublishedFiltered(?string $type, int $perPage): LengthAwarePaginator;
}
