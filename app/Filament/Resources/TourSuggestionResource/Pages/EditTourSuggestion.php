<?php

namespace App\Filament\Resources\TourSuggestionResource\Pages;

use App\Filament\Resources\TourSuggestionResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditTourSuggestion extends EditRecordWide
{
    protected static string $resource = TourSuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.tour_suggestions.show', ['previewTourSuggestion' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
