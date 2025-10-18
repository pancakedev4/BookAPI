<?php

namespace App\Filament\Resources\Translators\Pages;

use App\Filament\Resources\Translators\TranslatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTranslators extends ListRecords
{
    protected static string $resource = TranslatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
