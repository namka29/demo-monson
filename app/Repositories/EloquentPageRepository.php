<?php

namespace App\Repositories;

use App\Contracts\Repositories\PageRepositoryInterface;
use App\Models\Page;

class EloquentPageRepository implements PageRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Page
    {
        return Page::query()->published()->where('slug', $slug)->firstOrFail();
    }

    public function firstBySlugOrFail(string $slug): Page
    {
        return Page::query()->where('slug', $slug)->firstOrFail();
    }
}
