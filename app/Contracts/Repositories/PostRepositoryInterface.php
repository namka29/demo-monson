<?php

namespace App\Contracts\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Post;

    public function firstBySlugOrFail(string $slug): Post;

    public function paginatePublishedByPublishedAtDesc(int $perPage): LengthAwarePaginator;

    /** @return Collection<int, Post> */
    public function publishedHomeLatest(int $limit): Collection;
}
