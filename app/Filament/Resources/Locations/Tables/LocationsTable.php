<?php

namespace App\Filament\Resources\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LocationsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('customer.company_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state')
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
