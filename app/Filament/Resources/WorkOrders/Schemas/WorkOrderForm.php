<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->required(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(WorkOrderStatus::class)
                    ->default('draft')
                    ->required(),
                Select::make('priority')
                    ->options(WorkOrderPriority::class)
                    ->default('medium')
                    ->required(),
                DateTimePicker::make('scheduled_at'),
                DateTimePicker::make('due_at'),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
