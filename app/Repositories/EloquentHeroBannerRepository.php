<?php

namespace App\Repositories;

use App\Contracts\Repositories\HeroBannerRepositoryInterface;
use App\Models\HeroBanner;
use Illuminate\Support\Collection;

class EloquentHeroBannerRepository implements HeroBannerRepositoryInterface
{
    /** @inheritdoc */
    public function slideshowForHome(): Collection
    {
        return HeroBanner::query()
            ->where('is_active', true)
            ->whereNotNull('media_type')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->filter(static fn (HeroBanner $banner) => $banner->isRenderable())
            ->values();
    }

    public function nextDefaultSortOrder(): int
    {
        return ((int) (HeroBanner::query()->max('sort_order') ?? 0)) + 1;
    }
}
