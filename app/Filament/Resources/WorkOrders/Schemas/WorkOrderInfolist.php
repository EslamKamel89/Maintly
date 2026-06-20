<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class WorkOrderInfolist {
    public static function configure(Schema $schema): Schema {
        return $schema
            ->components([
                Tabs::make('Work Order')
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('organization.name')
                                            ->label('Organization')
                                            ->visible(
                                                fn() => auth()->user()?->isAdmin()
                                            ),

                                        TextEntry::make('customer.company_name')
                                            ->label('Customer'),

                                        TextEntry::make('creator.name')
                                            ->label('Created By'),

                                        TextEntry::make('title'),

                                        TextEntry::make('status')
                                            ->badge()
                                            ->formatStateUsing(
                                                fn(WorkOrderStatus $state) => $state->getLabel()
                                            )
                                            ->color(
                                                fn(WorkOrderStatus $state): string => match ($state) {
                                                    WorkOrderStatus::Draft => 'gray',
                                                    WorkOrderStatus::Open => 'info',
                                                    WorkOrderStatus::Assigned => 'warning',
                                                    WorkOrderStatus::InProgress => 'primary',
                                                    WorkOrderStatus::Completed => 'success',
                                                    WorkOrderStatus::Cancelled => 'danger',
                                                }
                                            ),

                                        TextEntry::make('priority')
                                            ->badge()
                                            ->formatStateUsing(
                                                fn(WorkOrderPriority $state) => $state->getLabel()
                                            )
                                            ->color(
                                                fn(WorkOrderPriority $state): string => match ($state) {
                                                    WorkOrderPriority::Low => 'gray',
                                                    WorkOrderPriority::Medium => 'info',
                                                    WorkOrderPriority::High => 'warning',
                                                    WorkOrderPriority::Critical => 'danger',
                                                }
                                            ),

                                        TextEntry::make('description')
                                            ->placeholder('-')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Resources')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('location.name')
                                            ->label('Location'),

                                        TextEntry::make('assets.name')
                                            ->label('Assets')
                                            ->badge()
                                            ->separator(','),

                                        TextEntry::make('technicians.name')
                                            ->label('Assigned Technicians')
                                            ->badge()
                                            ->separator(','),
                                    ])
                                    ->columns(1),
                            ]),

                        Tab::make('Scheduling')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('scheduled_at')
                                            ->label('Scheduled')
                                            ->dateTime()
                                            ->placeholder('-'),

                                        TextEntry::make('due_at')
                                            ->label('Due')
                                            ->dateTime()
                                            ->placeholder('-'),

                                        TextEntry::make('started_at')
                                            ->label('Started')
                                            ->dateTime()
                                            ->placeholder('-'),

                                        TextEntry::make('completed_at')
                                            ->label('Completed')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Audit')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Created')
                                            ->dateTime(),

                                        TextEntry::make('updated_at')
                                            ->label('Last Updated')
                                            ->dateTime(),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),
            ])
            ->columns(1);
    }
}
