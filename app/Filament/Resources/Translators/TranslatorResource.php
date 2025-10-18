<?php

namespace App\Filament\Resources\Translators;

use App\Filament\Resources\Translators\Pages\CreateTranslator;
use App\Filament\Resources\Translators\Pages\EditTranslator;
use App\Filament\Resources\Translators\Pages\ListTranslators;
use App\Filament\Resources\Translators\Schemas\TranslatorForm;
use App\Filament\Resources\Translators\Tables\TranslatorsTable;
use App\Models\Translator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TranslatorResource extends Resource
{
    protected static ?string $model = Translator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TranslatorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TranslatorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTranslators::route('/'),
            'create' => CreateTranslator::route('/create'),
            'edit' => EditTranslator::route('/{record}/edit'),
        ];
    }
}
