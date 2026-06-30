<?php

namespace App\Filament\Resources\UserLocations\Schemas;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class UserLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Trace Information')
                    ->schema([
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->visible(
                                fn () => auth()->user()?->isAdmin()
                            )
                            ->default(
                                fn () => auth()->user()?->isAdmin()
                                    ? null
                                    : auth()->user()->organization_id
                            )
                            ->afterStateUpdated(function (Set $set): void {
                                $set('user_id', null);
                            })
                            ->required()
                            ->dehydrated(),

                        Select::make('user_id')
                            ->label('Technician')
                            ->disabled(
                                fn (Get $get) => blank($get('organization_id'))
                            )
                            ->options(function (Get $get) {
                                $organizationId = $get('organization_id');

                                if (! $organizationId) {
                                    return [];
                                }

                                return User::query()
                                    ->where('organization_id', $organizationId)
                                    ->where('role', UserRole::Technician)
                                    ->orderBy('name')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Coordinates & Map')
                    ->description(
                        'Open Google Maps, search for the location, right-click the exact point and choose "What\'s here?". Paste the coordinates below.'
                    )
                    ->schema([
                        TextInput::make('coordinates')
                            ->label('Coordinates')
                            ->placeholder('31.04436632472261, 31.353278998271733')
                            ->live(debounce: 200)
                            ->afterStateUpdated(function (
                                ?string $state,
                                Set $set
                            ): void {
                                if (blank($state)) {
                                    return;
                                }

                                $parts = array_map(
                                    'trim',
                                    explode(',', $state)
                                );

                                if (count($parts) !== 2) {
                                    return;
                                }

                                if (
                                    ! is_numeric($parts[0]) ||
                                    ! is_numeric($parts[1])
                                ) {
                                    return;
                                }

                                $set('latitude', (float) $parts[0]);
                                $set('longitude', (float) $parts[1]);
                            })
                            ->suffixAction(
                                Action::make('openGoogleMaps')
                                    ->label('Google Maps')
                                    ->icon('heroicon-o-map')
                                    ->url(
                                        'https://maps.google.com',
                                        shouldOpenInNewTab: true
                                    )
                            )
                            ->columnSpanFull(),

                        TextInput::make('latitude')
                            ->required()
                            ->numeric(),

                        TextInput::make('longitude')
                            ->required()
                            ->numeric(),

                        Action::make('openGoogleMapsLocation')
                            ->label('View Current Coordinates on Google Maps')
                            ->icon('heroicon-o-map')
                            ->url(
                                fn (Get $get) => filled($get('latitude'))
                                    && filled($get('longitude'))
                                    ? 'https://www.google.com/maps?q='.
                                    $get('latitude').','.$get('longitude')
                                    : 'https://www.google.com/maps'
                            )
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2),
            ])
            ->columns(1);
    }
}
