<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Models\Customer;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocationForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Location Information')
                    ->schema([
                        // Select::make('organization_id')
                        //     ->relationship('organization', 'name')
                        //     ->searchable()
                        //     ->preload()
                        //     ->visible(
                        //         fn() => auth()->user()?->isAdmin()
                        //     )
                        //     ->default(
                        //         fn() => auth()->user()?->isAdmin()
                        //             ? null
                        //             : auth()->user()->organization_id
                        //     )
                        //     ->dehydrated(),

                        // Select::make('customer_id')
                        //     ->relationship('customer', 'company_name')
                        //     ->default(fn() => request()->route('customer'))
                        //     ->hidden()
                        //     ->required()
                        //     ->dehydrated(),
                        Hidden::make('customer_id')
                            ->default(fn() => request()->route('customer')),
                        Hidden::make('organization_id')
                            ->default(function () {
                                $customerId = request()->route('customer');
                                $customer = Customer::findOrFail($customerId);
                                return $customer->organization_id;
                            }),

                        TextInput::make('name')
                            ->label('Location Name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Coordinates & Map')
                    ->description(
                        'Open Google Maps, search for the location, right-click the exact point and choose "What\'s here?". Paste the coordinates below, then use the map for visual verification or small adjustments.'
                    )
                    ->schema([
                        TextInput::make('coordinates')
                            ->label('Coordinates')
                            ->placeholder('31.04436632472261, 31.353278998271733')
                            ->live(debounce: 200)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                if (blank($state)) {
                                    return;
                                }

                                $parts = array_map('trim', explode(',', $state));

                                if (count($parts) !== 2) {
                                    return;
                                }

                                if (! is_numeric($parts[0]) || ! is_numeric($parts[1])) {
                                    return;
                                }

                                $set('latitude', (float) $parts[0]);
                                $set('longitude', (float) $parts[1]);
                            })
                            ->suffixAction(
                                Action::make('openGoogleMaps')
                                    ->label('Google Maps')
                                    ->icon('heroicon-o-map')
                                    ->url('https://maps.google.com', shouldOpenInNewTab: true)
                            )
                            ->columnSpanFull(),

                        TextInput::make('latitude')
                            ->numeric(),

                        TextInput::make('longitude')
                            ->numeric(),

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

                        // MapPicker::make('location')
                        //     ->label('Map Preview / Fine Adjustment')
                        //     ->height(350)
                        //     ->autoCenter()
                        //     ->columnSpanFull()
                        //     ->onMapClick(
                        //         function (
                        //             float $latitude,
                        //             float $longitude,
                        //             callable $set
                        //         ): void {
                        //             $set('latitude', $latitude);
                        //             $set('longitude', $longitude);
                        //         }
                        //     ),
                    ])
                    ->columns(2),

                Section::make('Address Details')
                    ->schema([
                        Textarea::make('address')
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->maxLength(255),

                        TextInput::make('state')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('notes')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ])
            ->columns(1);
    }
}
