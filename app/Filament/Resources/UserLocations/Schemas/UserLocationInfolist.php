<?php

namespace App\Filament\Resources\UserLocations\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserLocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Trace Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn () => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('user.name')
                            ->label('Technician'),

                        TextEntry::make('created_at')
                            ->label('Recorded At')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Section::make('Coordinates')
                    ->schema([
                        TextEntry::make('latitude')
                            ->numeric(decimalPlaces: 7),

                        TextEntry::make('longitude')
                            ->numeric(decimalPlaces: 7),

                        Action::make('openGoogleMapsLocation')
                            ->label('View on Google Maps')
                            ->icon('heroicon-o-map')
                            ->url(
                                fn (callable $get) => filled($get('latitude'))
                                    && filled($get('longitude'))
                                    ? 'https://www.google.com/maps?q='.
                                    $get('latitude').','.$get('longitude')
                                    : 'https://www.google.com/maps'
                            )
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2),

                Section::make('Audit Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Recorded At')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
