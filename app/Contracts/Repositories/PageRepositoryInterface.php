<?php

namespace App\Contracts\Repositories;

use App\Models\Page;

interface PageRepositoryInterface
{
    public function firstPublishedBySlugOrFail(string $slug): Page;

    public function firstBySlugOrFail(string $slug): Page;
}
