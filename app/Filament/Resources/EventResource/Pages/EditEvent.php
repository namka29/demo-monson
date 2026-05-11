<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditEvent extends EditRecordWide
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.events.show', ['previewEvent' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
