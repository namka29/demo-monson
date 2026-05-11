<?php

namespace App\Contracts\Repositories;

use App\Models\HeroSlideshowSetting;

interface HeroSlideshowSettingRepositoryInterface
{
    /** Bản ghi đầu tiên nếu có (dùng cho menu / nút chỉnh sửa, không auto-create). */
    public function firstOrNull(): ?HeroSlideshowSetting;

    /** Một bản ghi singleton (GET-or-create — thống nhất với trang chủ & admin chỉnh thời gian). */
    public function getOrCreateSingleton(): HeroSlideshowSetting;

    /** Thời gian autoplay đưa vào `data-autoplay-interval` (ms, đã clamp). */
    public function autoplayMilliseconds(): int;
}
