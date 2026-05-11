<?php

namespace App\Repositories;

use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Models\HeroSlideshowSetting;
use Illuminate\Support\Facades\Schema;

class EloquentHeroSlideshowSettingRepository implements HeroSlideshowSettingRepositoryInterface
{
    public function firstOrNull(): ?HeroSlideshowSetting
    {
        if (! Schema::hasTable('hero_slideshow_settings')) {
            return null;
        }

        /** @var HeroSlideshowSetting|null */
        return HeroSlideshowSetting::query()->orderBy('id')->first();
    }

    public function getOrCreateSingleton(): HeroSlideshowSetting
    {
        if (! Schema::hasTable('hero_slideshow_settings')) {
            throw new \RuntimeException('Migration hero_slideshow_settings chưa chạy.');
        }

        $existing = HeroSlideshowSetting::query()->orderBy('id')->first();

        return $existing instanceof HeroSlideshowSetting
            ? $existing
            : HeroSlideshowSetting::query()->create([
                'autoplay_interval_ms' => $this->defaultIntervalFromConfig(),
            ]);
    }

    public function autoplayMilliseconds(): int
    {
        if (! Schema::hasTable('hero_slideshow_settings')) {
            return $this->clampMs($this->defaultIntervalFromConfig());
        }

        $row = HeroSlideshowSetting::query()->orderBy('id')->first();
        if (! $row instanceof HeroSlideshowSetting) {
            $row = HeroSlideshowSetting::query()->create([
                'autoplay_interval_ms' => $this->defaultIntervalFromConfig(),
            ]);
        }

        return $this->clampMs((int) $row->autoplay_interval_ms);
    }

    protected function defaultIntervalFromConfig(): int
    {
        return $this->clampMs((int) config('tourist.hero_slide_autoplay_ms', 6500));
    }

    protected function clampMs(int $ms): int
    {
        return max(0, min(600_000, $ms));
    }
}
