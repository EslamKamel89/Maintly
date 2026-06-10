<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Organization Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('address')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ])->columns(1);
    }
}
