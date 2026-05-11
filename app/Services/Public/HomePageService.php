<?php

namespace App\Services\Public;

use App\Contracts\Repositories\DestinationRepositoryInterface;
use App\Contracts\Repositories\EventRepositoryInterface;
use App\Contracts\Repositories\HeroBannerRepositoryInterface;
use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Contracts\Repositories\PostRepositoryInterface;

class HomePageService
{
    public function __construct(
        protected DestinationRepositoryInterface $destinations,
        protected EventRepositoryInterface $events,
        protected PostRepositoryInterface $posts,
        protected HeroBannerRepositoryInterface $heroBanners,
        protected HeroSlideshowSettingRepositoryInterface $heroSlideshowSettings,
    ) {}

    /** @return array<string, mixed> */
    public function buildViewData(): array
    {
        return [
            'destinations' => $this->destinations->publishedHomeFeatured(6),
            'events' => $this->events->publishedHomeLatest(5),
            'posts' => $this->posts->publishedHomeLatest(5),
            'heroSlides' => $this->heroBanners->slideshowForHome(),
            'heroSlideAutoplayMs' => $this->heroSlideshowSettings->autoplayMilliseconds(),
        ];
    }
}
