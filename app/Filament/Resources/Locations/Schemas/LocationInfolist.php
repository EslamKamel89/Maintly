<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocationInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Location Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('customer.company_name')
                            ->label('Customer'),

                        TextEntry::make('name')
                            ->label('Location'),

                        TextEntry::make('address')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('city')
                            ->placeholder('-'),

                        TextEntry::make('state')
                            ->placeholder('-'),

                        TextEntry::make('latitude')
                            ->numeric()
                            ->placeholder('-'),

                        TextEntry::make('longitude')
                            ->numeric()
                            ->placeholder('-'),

                        TextEntry::make('notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Audit Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),
                    ]),
            ])
            ->columns(1);
    }
}
