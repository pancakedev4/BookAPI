<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Mail\Markdown;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('author_id')
                    ->relationship('authors', 'surname')
                    ->multiple()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->surname)
                    ->searchable(['name', 'surname'])
                    ->required(),
                Select::make('translator_id')
                    ->relationship('translators', 'surname')
                    ->multiple()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->surname)
                    ->searchable(['name', 'surname']),
                Select::make('reciter_id')
                    ->relationship('reciters', 'surname')
                    ->multiple()
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name . ' ' . $record->surname)
                    ->searchable(['name', 'surname']),
                Select::make('publishing_id')
                    ->relationship('publishing', 'title')
                    ->required(),
                Select::make('genre_id')
                    ->relationship('genres', 'title')
                    ->multiple(),
                Select::make('type_of_book_id')
                    ->relationship('type_of_book', 'type')
                    ->required(),
                TextInput::make('title'),
                TextInput::make('description_small'),
                TextInput::make('year of publication'),
                TextInput::make('language'),
                FileUpload::make('image')
                ->imageEditor()
                ->disk('public'),
                MarkdownEditor::make('description')->columnSpanFull()
                //
            ]);
    }
}
