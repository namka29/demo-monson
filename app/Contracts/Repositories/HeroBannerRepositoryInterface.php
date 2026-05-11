<?php

namespace App\Contracts\Repositories;

use App\Models\HeroBanner;
use Illuminate\Support\Collection;

interface HeroBannerRepositoryInterface
{
    /** @return Collection<int, HeroBanner> Slide hiển thị trang chủ: active + đủ media + đúng thứ tự. */
    public function slideshowForHome(): Collection;

    /** Giá trị sort_order mặc định khi tạo slide mới (admin). */
    public function nextDefaultSortOrder(): int;
}
