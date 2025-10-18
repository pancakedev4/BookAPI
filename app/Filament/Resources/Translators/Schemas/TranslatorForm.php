<?php

namespace App\Filament\Resources\Translators\Schemas;

use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

class TranslatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('name'),
                TextInput::make('surname')
            ]);
    }
}
