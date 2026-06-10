<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Organization Information')
                    ->schema([
                        TextEntry::make('name'),

                        TextEntry::make('phone_number')
                            ->label('Phone')
                            ->placeholder('-'),

                        TextEntry::make('address')
                            ->placeholder('-'),

                        TextEntry::make('description')
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
            ])->columns(1);
    }
}
