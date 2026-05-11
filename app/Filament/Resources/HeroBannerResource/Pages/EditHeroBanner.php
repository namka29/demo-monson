<?php

namespace App\Filament\Resources\HeroBannerResource\Pages;

use App\Filament\Resources\HeroBannerResource;
use App\Filament\Resources\Pages\EditRecordWide;

class EditHeroBanner extends EditRecordWide
{
    protected static string $resource = HeroBannerResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return HeroBannerResource::validateYoutubeInFormData($data);
    }
}
