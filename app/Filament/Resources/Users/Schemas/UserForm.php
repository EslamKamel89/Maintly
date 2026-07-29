<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Information')
                    ->schema([
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->disabled(
                                fn () => ! auth()->user()?->isAdmin()
                            )
                            ->live()
                            ->default(
                                fn () => auth()->user()?->isAdmin()
                                    ? null
                                    : auth()->user()->organization_id
                            )->dehydrated(true),

                        Select::make('role')
                            ->options(function (): array {
                                $user = auth()->user();

                                if ($user?->isAdmin()) {
                                    return collect(UserRole::cases())
                                        ->mapWithKeys(fn (UserRole $role) => [
                                            $role->value => $role->label(),
                                        ])
                                        ->all();
                                }

                                if ($user?->isOwner()) {
                                    return [
                                        UserRole::Manager->value => UserRole::Manager->label(),
                                        UserRole::Technician->value => UserRole::Technician->label(),
                                    ];
                                }

                                return [
                                    UserRole::Technician->value => UserRole::Technician->label(),
                                ];
                            })
                            ->native(false)
                            ->required(),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->maxLength(255)
                            ->required(),
                    ]),

                Section::make('Security')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(
                                fn (string $operation) => $operation === 'create'
                            )
                            ->dehydrated(
                                fn ($state) => filled($state)
                            )
                            ->dehydrateStateUsing(
                                fn (string $state): string => Hash::make($state)
                            ),
                    ]),
            ]);
    }
}
