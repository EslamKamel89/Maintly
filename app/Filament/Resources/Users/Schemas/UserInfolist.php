<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Account Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('role')
                            ->badge()
                            ->color(fn(UserRole $state): string => match ($state) {
                                UserRole::Admin => 'danger',
                                UserRole::Owner => 'warning',
                                UserRole::Manager => 'info',
                                UserRole::Technician => 'gray',
                            }),

                        TextEntry::make('name'),

                        TextEntry::make('email')
                            ->label('Email Address'),
                    ])
                    ->columns(2),

                Section::make('Audit Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),
                    ]),
            ]);
    }
}
