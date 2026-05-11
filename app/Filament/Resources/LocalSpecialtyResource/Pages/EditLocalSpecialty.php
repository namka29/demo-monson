<?php

namespace App\Filament\Resources\LocalSpecialtyResource\Pages;

use App\Filament\Resources\LocalSpecialtyResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditLocalSpecialty extends EditRecordWide
{
    protected static string $resource = LocalSpecialtyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.local_specialties.show', ['previewLocalSpecialty' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
