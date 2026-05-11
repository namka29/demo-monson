<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

abstract class CreateRecordWide extends CreateRecord
{
    protected Width | string | null $maxContentWidth = Width::Full;

    /**
     * Filament mặc định bọc resource form trong lưới 2 cột; khi chỉ có 1 khối (vd. một Section),
     * khối đó chỉ chiếm cột đầu — cột còn lại trống. Dùng 1 cột ở tầng ngoài, để các Section
     * tự `->columns(2)` bên trong.
     */
    public function defaultForm(Schema $schema): Schema
    {
        if (! $schema->hasCustomColumns()) {
            $schema->columns(1);
        }

        return parent::defaultForm($schema);
    }
}
