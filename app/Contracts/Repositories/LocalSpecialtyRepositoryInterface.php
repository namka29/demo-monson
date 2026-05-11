<?php

namespace App\Contracts\Repositories;

use App\Models\LocalSpecialty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LocalSpecialtyRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): LocalSpecialty;

    public function firstBySlugOrFail(string $slug): LocalSpecialty;

    public function paginatePublishedFiltered(?string $category, int $perPage): LengthAwarePaginator;
}
