<?php

namespace App\Filament\Resources\Locations\Schemas;

use App\Context\OrganizationContext;
use Filament\Forms\Components\Select;
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
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            )
                            ->default(
                                fn() => auth()->user()?->isAdmin()
                                    ? null
                                    : OrganizationContext::id()
                            )->dehydrated(),

                        Select::make('customer_id')
                            ->relationship('customer', 'company_name')
                            ->default(fn() => request()->route('customer'))
                            ->hidden()
                            ->required()
                            ->dehydrated(),
                        // ->searchable()
                        // ->preload()

                        TextInput::make('name')
                            ->label('Location Name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('address')
                            ->columnSpanFull(),

                        TextInput::make('city')
                            ->maxLength(255),

                        TextInput::make('state')
                            ->maxLength(255),

                        TextInput::make('latitude')
                            ->numeric(),

                        TextInput::make('longitude')
                            ->numeric(),
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
