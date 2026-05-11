<?php

namespace App\Filament\Resources\HeroBannerResource\Pages;

use App\Contracts\Repositories\HeroSlideshowSettingRepositoryInterface;
use App\Filament\Resources\HeroBannerResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class ListHeroBanners extends ListRecords
{
    protected static string $resource = HeroBannerResource::class;

    protected function getHeaderActions(): array
    {
        $actions = parent::getHeaderActions();

        if (! Schema::hasTable('hero_slideshow_settings')) {
            return $actions;
        }

        $slideshowRow = app(HeroSlideshowSettingRepositoryInterface::class)->firstOrNull();
        if ($slideshowRow !== null && Gate::allows('update', $slideshowRow)) {
            $actions[] = Action::make('slideshowTiming')
                ->label('Thời gian slideshow')
                ->icon('heroicon-o-clock')
                ->url(HeroBannerResource::getUrl('slideshow-timing'));
        }

        return $actions;
    }
}
