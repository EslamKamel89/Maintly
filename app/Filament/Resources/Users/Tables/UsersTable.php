<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserRole;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('role')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->color(fn(UserRole $state): string => match ($state) {
                        UserRole::Admin => 'danger',
                        UserRole::Owner => 'warning',
                        UserRole::Manager => 'info',
                        UserRole::Technician => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(
                        collect(UserRole::cases())
                            ->mapWithKeys(fn(UserRole $role) => [
                                $role->value => $role->label(),
                            ])
                            ->all()
                    ),

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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
