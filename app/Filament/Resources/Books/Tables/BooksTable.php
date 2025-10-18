<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Название'),
                TextColumn::make('authors.full_name')
                    ->label('Автор')
                    ->getStateUsing(function ($record) {
                        return $record->authors
                            ->map(fn($author) => $author->name . ' ' . $author->surname)
                            ->join(', ');
                    })
                    ->searchable(
                        query: fn(Builder $query, string $search) => $query
                            ->whereHas(
                                'authors',
                                fn($q) => $q
                                    ->where('name', 'like', "%{$search}%")
                                    ->orWhere('surname', 'like', "%{$search}%")
                            )
                    ),
                TextColumn::make('translators.full_name')
                    ->label('Переводчик')
                    ->getStateUsing(function ($record) {
                        return $record->translators
                            ->map(fn($translator) => $translator->name . ' ' . $translator->surname)
                            ->join(', ');
                    })
                    ->searchable(
                        query: fn(Builder $query, string $search) => $query
                            ->whereHas(
                                'translators',
                                fn($q) => $q
                                    ->where('name', 'like', "%{$search}%")
                                    ->orWhere('surname', 'like', "%{$search}%")
                            )
                    ),
                TextColumn::make('reciters.full_name')
                    ->label('Чтец')
                    ->getStateUsing(function ($record) {
                        return $record->reciters
                            ->map(fn($reciter) => $reciter->name . ' ' . $reciter->surname)
                            ->join(', ');
                    })
                    ->searchable(
                        query: fn(Builder $query, string $search) => $query
                            ->whereHas(
                                'reciters',
                                fn($q) => $q
                                    ->where('name', 'like', "%{$search}%")
                                    ->orWhere('surname', 'like', "%{$search}%")
                            )
                    ),
                TextColumn::make('publishing.title')->label('Издательство'),
                TextColumn::make('genres.title')->label('Жанр'),
                TextColumn::make('type_of_book.type')->label('Тип'),
                TextColumn::make('description_small')->label('Краткое описание')
                    ->limit(50) // Ограничить количество символов
                    ->tooltip(fn($record): string => $record->description), // Показать полный текст при наведении,
                TextColumn::make('description')->label('Полное описание')
                    ->limit(50) // Ограничить количество символов
                    ->tooltip(fn($record): string => $record->description), // Показать полный текст при наведении,
                TextColumn::make('year of publication')->label('Год публикации'),
                TextColumn::make('language')->label('Язык'),
                ImageColumn::make('image')
                    ->disk('public')
                    ->extraImgAttributes(['title' => 'Image preview'])
                    ->label('Изображение'),
                //
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
