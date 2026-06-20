<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use App\Enums\UserRole;
use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Location;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class WorkOrderForm {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Tabs::make('Work Order')
                    ->tabs([
                        Tab::make('General')
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
                                        $set('customer_id', null);
                                        $set('location_id', null);
                                        $set('assets', []);
                                        $set('technicians', []);
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

                                        return Customer::query()
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
                                        $set('assets', []);
                                    }),


                                Select::make('status')
                                    ->options(WorkOrderStatus::class)
                                    ->default(WorkOrderStatus::Draft)
                                    ->required(),

                                Select::make('priority')
                                    ->options(WorkOrderPriority::class)
                                    ->default(WorkOrderPriority::Medium)
                                    ->required(),

                                Textarea::make('description')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Resources')
                            ->schema([
                                Select::make('location_id')
                                    ->label('Location')
                                    ->helperText('You have to select the customer first')
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
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('assets', []);
                                    })
                                    ->required(),

                                Select::make('assets')
                                    ->label('Assets')
                                    ->helperText('You have to select the Location first')
                                    ->relationship(
                                        name: 'assets',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: function (
                                            Builder $query,
                                            Get $get
                                        ) {
                                            $locationId = $get('location_id');

                                            if (!$locationId) {
                                                $query->whereRaw('1 = 0');

                                                return;
                                            }

                                            $query->where(
                                                'location_id',
                                                $locationId
                                            );
                                        }
                                    )
                                    ->disabled(
                                        fn(Get $get) => blank($get('location_id'))
                                    )
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->suffixAction(
                                        Action::make('select_all')
                                            ->button()
                                            ->label('Select All')
                                            ->action(function (Get $get, Set $set) {
                                                $locationId = $get('location_id');
                                                if (!$locationId) return;
                                                $assetIds = Asset::query()
                                                    ->where('location_id', $locationId)
                                                    ->pluck('id');
                                                $set('assets', $assetIds);
                                            }),
                                    ),

                                Select::make('technicians')
                                    ->label('Assigned Technicians')

                                    ->disabled(
                                        fn(Get $get) => blank($get('organization_id'))
                                    )
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->relationship(
                                        name: 'technicians',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: function (
                                            Builder $query,
                                            Get $get
                                        ) {
                                            $organizationId = $get('organization_id');

                                            if (!$organizationId) {
                                                $query->whereRaw('1 = 0');

                                                return;
                                            }

                                            $query
                                                ->where(
                                                    'organization_id',
                                                    $organizationId
                                                )
                                                ->where(
                                                    'role',
                                                    UserRole::Technician
                                                );
                                        }
                                    )
                                    ->pivotData([
                                        'assigned_by' => auth()->id(),
                                        'assigned_at' => now(),
                                    ]),
                            ]),

                        Tab::make('Scheduling')
                            ->schema([
                                DateTimePicker::make('scheduled_at'),

                                DateTimePicker::make('due_at'),

                                DateTimePicker::make('started_at'),

                                DateTimePicker::make('completed_at'),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->columns(1);
    }
}
