<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Customer Information')
                    ->schema([
                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            ),

                        TextEntry::make('company_name'),

                        TextEntry::make('contact_person')
                            ->placeholder('-'),

                        TextEntry::make('phone')
                            ->placeholder('-'),

                        TextEntry::make('email')
                            ->label('Email Address')
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
            ])->columns(1);
    }
}
