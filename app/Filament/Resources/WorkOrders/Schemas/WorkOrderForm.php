<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Customer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use App\Models\Location;
use Filament\Forms\Components\TextInput;

class WorkOrderForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Work Order Information')
                    ->schema([
                        Select::make('organization_id')
                            ->relationship('organization', 'name')
                            ->live()
                            ->searchable()
                            ->preload()
                            ->visible(
                                fn() => auth()->user()?->isAdmin()
                            )
                            ->default(
                                fn() => auth()->user()?->isAdmin()
                                    ? null
                                    : auth()->user()->organization_id
                            )
                            ->afterStateUpdated(function (Set $set) {
                                $set('location_id', null);
                                $set('customer_id', null);
                            })
                            ->required()
                            ->dehydrated(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        Select::make('customer_id')
                            ->label('Customer')
                            ->disabled(
                                fn(Get $get) => blank($get('organization_id'))
                            )
                            ->options(function (Get $get) {
                                $organizationId = $get('organization_id');
                                if (!$organizationId) {
                                    return [];
                                }
                                return  Customer::query()
                                    ->where('organization_id', $organizationId)
                                    ->orderBy('company_name')
                                    ->pluck('company_name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('location_id', null);
                            }),

                        Select::make('location_id')
                            ->label('Location')
                            ->disabled(
                                fn(Get $get) => blank($get('customer_id'))
                            )
                            ->options(function (Get $get) {
                                $customerId = $get('customer_id');
                                if (!$customerId) {
                                    return [];
                                }
                                return Location::query()
                                    ->where('customer_id', $customerId)
                                    ->orderBy('name')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),



                        Select::make('status')
                            ->options(WorkOrderStatus::class)
                            ->default(WorkOrderStatus::Draft)
                            ->required(),

                        Select::make('priority')
                            ->options(WorkOrderPriority::class)
                            ->default(WorkOrderPriority::Medium)
                            ->required(),


                    ])
                    ->columns(2),

                Section::make('Scheduling')
                    ->schema([
                        DateTimePicker::make('scheduled_at'),

                        DateTimePicker::make('due_at'),

                        DateTimePicker::make('started_at'),

                        DateTimePicker::make('completed_at'),
                    ])
                    ->columns(2),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ])
            ->columns(1);
    }
}
