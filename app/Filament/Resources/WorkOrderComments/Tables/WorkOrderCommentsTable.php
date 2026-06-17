<?php

namespace App\Filament\Resources\WorkOrderComments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkOrderCommentsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('workOrder.title')
                    ->label('Work Order')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(80)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->stackedOnMobile()
            ->filters([
                SelectFilter::make('organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                SelectFilter::make('workOrder')
                    ->relationship('workOrder', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
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
