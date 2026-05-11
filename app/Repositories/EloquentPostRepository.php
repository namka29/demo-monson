<?php

namespace App\Repositories;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Post
    {
        return Post::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): Post
    {
        return Post::query()->where('slug', $slug)->firstOrFail();
    }

    public function paginatePublishedByPublishedAtDesc(int $perPage): LengthAwarePaginator
    {
        return Post::query()->published()->orderByDesc('published_at')->paginate($perPage);
    }

    /** @inheritdoc */
    public function publishedHomeLatest(int $limit): \Illuminate\Database\Eloquent\Collection
    {
        return Post::query()->published()->orderByDesc('published_at')->limit($limit)->get();
    }
}
