<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('location.name')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Asset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('asset_code')
                    ->label('Asset Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('manufacturer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make()
                    ->disabled(
                        auth()->user()?->isTechnician()
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->disabled(
                            auth()->user()?->isTechnician()
                        ),
                ]),
            ]);
    }
}
