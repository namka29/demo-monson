<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditPage extends EditRecordWide
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.pages.show', ['previewPage' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
