<?php

namespace App\Filament\Resources\HeroBannerResource\Pages;

use App\Filament\Resources\HeroBannerResource;
use App\Filament\Resources\Pages\CreateRecordWide;

class CreateHeroBanner extends CreateRecordWide
{
    protected static string $resource = HeroBannerResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return HeroBannerResource::validateYoutubeInFormData($data);
    }
}
