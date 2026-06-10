<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('asset_code')
                    ->required(),
                TextInput::make('manufacturer'),
                TextInput::make('model'),
                TextInput::make('serial_number'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
