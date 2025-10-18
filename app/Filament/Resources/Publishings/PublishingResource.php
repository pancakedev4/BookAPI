<?php

namespace App\Filament\Resources\Publishings;

use App\Filament\Resources\Publishings\Pages\CreatePublishing;
use App\Filament\Resources\Publishings\Pages\EditPublishing;
use App\Filament\Resources\Publishings\Pages\ListPublishings;
use App\Filament\Resources\Publishings\Schemas\PublishingForm;
use App\Filament\Resources\Publishings\Tables\PublishingsTable;
use App\Models\Publishing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PublishingResource extends Resource
{
    protected static ?string $model = Publishing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PublishingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublishingsTable::configure($table);
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
            'index' => ListPublishings::route('/'),
            'create' => CreatePublishing::route('/create'),
            'edit' => EditPublishing::route('/{record}/edit'),
        ];
    }
}
