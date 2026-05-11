<?php

namespace App\Filament\Resources\Pages;

use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

abstract class EditRecordWide extends EditRecord
{
    protected Width | string | null $maxContentWidth = Width::Full;

    /**
     * @see CreateRecordWide::defaultForm()
     */
    public function defaultForm(Schema $schema): Schema
    {
        if (! $schema->hasCustomColumns()) {
            $schema->columns(1);
        }

        return parent::defaultForm($schema);
    }
}
