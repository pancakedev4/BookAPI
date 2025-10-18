<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Category;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        $arr = Category::where('parent_id', 0)->pluck('title', 'id')->toArray();

        return $schema
            ->components([
                //
                TextInput::make('title'),
                Select::make('parent_id')->options($arr)
            ]);
    }
}
