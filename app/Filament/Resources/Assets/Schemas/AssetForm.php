<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Location;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Asset Information')
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

                        // Select::make('location_id')
                        //     ->relationship('location', 'name')
                        //     ->hidden()
                        //     ->default(fn() => request()->route('location'))
                        //     ->required()
                        //     ->dehydrated(),
                        // ->searchable()
                        // ->preload()
                        Hidden::make('location_id')
                            ->default(fn() => request()->route('location')),
                        Hidden::make('organization_id')
                            ->default(function () {
                                $locationId = request()->route('location');
                                $location = Location::findOrFail($locationId);
                                return $location->organization_id;
                            }),
                        TextInput::make('name')
                            ->label('Asset Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('asset_code')
                            ->label('Asset Code')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('manufacturer')
                            ->maxLength(255),

                        TextInput::make('model')
                            ->maxLength(255),

                        TextInput::make('serial_number')
                            ->label('Serial Number')
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
