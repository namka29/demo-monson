<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions\Action;
use App\Filament\Resources\Pages\EditRecordWide;

class EditPost extends EditRecordWide
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Action::make('preview_web')
                ->label('Xem trước trên web')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn (): string => route('preview.posts.show', ['previewPost' => $this->record->slug]))
                ->openUrlInNewTab(),
        ];
    }
}
