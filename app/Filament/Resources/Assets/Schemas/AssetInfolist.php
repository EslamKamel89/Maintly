<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Asset Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('location.name')
                            ->label('Location'),

                        TextEntry::make('name')
                            ->label('Asset'),

                        TextEntry::make('asset_code')
                            ->label('Asset Code'),

                        TextEntry::make('manufacturer')
                            ->placeholder('-'),

                        TextEntry::make('model')
                            ->placeholder('-'),

                        TextEntry::make('serial_number')
                            ->label('Serial Number')
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
