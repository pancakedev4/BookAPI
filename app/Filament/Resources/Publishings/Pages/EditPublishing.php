<?php

namespace App\Filament\Resources\Publishings\Pages;

use App\Filament\Resources\Publishings\PublishingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublishing extends EditRecord
{
    protected static string $resource = PublishingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
