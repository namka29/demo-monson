<?php

namespace App\Filament\Resources\DestinationResource\Pages;

use App\Filament\Resources\DestinationResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditDestination extends EditRecordWide
{
    protected static string $resource = DestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.destinations.show', ['previewDestination' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
