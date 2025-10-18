<?php

namespace App\Filament\Resources\Publishings\Schemas;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

class PublishingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')
            ]);
    }
}
