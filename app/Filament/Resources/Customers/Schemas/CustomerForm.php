<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Context\OrganizationContext;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Customer Information')
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

                        TextInput::make('company_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('contact_person')
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('notes')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ])->columns(1);
    }
}
