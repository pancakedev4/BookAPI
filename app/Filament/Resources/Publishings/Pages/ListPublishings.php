<?php

namespace App\Filament\Resources\Publishings\Pages;

use App\Filament\Resources\Publishings\PublishingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublishings extends ListRecords
{
    protected static string $resource = PublishingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
