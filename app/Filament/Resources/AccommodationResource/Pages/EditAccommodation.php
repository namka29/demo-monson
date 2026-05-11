<?php

namespace App\Filament\Resources\AccommodationResource\Pages;

use App\Filament\Resources\AccommodationResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditAccommodation extends EditRecordWide
{
    protected static string $resource = AccommodationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.accommodations.show', ['previewAccommodation' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
