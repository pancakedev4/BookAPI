<?php

namespace App\Filament\Resources\Translators\Pages;

use App\Filament\Resources\Translators\TranslatorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTranslator extends EditRecord
{
    protected static string $resource = TranslatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
