<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Actions\Action;
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
                            ->label('Location Name'),
                    ])
                    ->columns(2),

                Section::make('Coordinates')
                    ->schema([
                        TextEntry::make('latitude')
                            ->numeric()
                            ->placeholder('-'),

                        TextEntry::make('longitude')
                            ->numeric()
                            ->placeholder('-'),
                        Action::make('openGoogleMapsLocation')
                            ->label('View Current Coordinates on Google Maps')
                            ->icon('heroicon-o-map')
                            ->url(
                                fn(callable $get) => filled($get('latitude')) && filled($get('longitude'))
                                    ? 'https://www.google.com/maps?q=' .
                                    $get('latitude') . ',' . $get('longitude')
                                    : 'https://www.google.com/maps'
                            )
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2),

                Section::make('Address Details')
                    ->schema([
                        TextEntry::make('address')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('city')
                            ->placeholder('-'),

                        TextEntry::make('state')
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('notes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

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
