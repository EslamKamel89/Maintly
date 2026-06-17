<?php

namespace App\Filament\Resources\WorkOrders\Tables;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkOrdersTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('customer.company_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(
                        fn(WorkOrderStatus $state) => $state->getLabel()
                    )
                    ->colors([
                        'gray' => WorkOrderStatus::Draft,
                        'info' => WorkOrderStatus::Open,
                        'warning' => WorkOrderStatus::Assigned,
                        'primary' => WorkOrderStatus::InProgress,
                        'success' => WorkOrderStatus::Completed,
                        'danger' => WorkOrderStatus::Cancelled,
                    ])
                    ->sortable(),

                TextColumn::make('priority')
                    ->badge()
                    ->formatStateUsing(
                        fn(WorkOrderPriority $state) => $state->getLabel()
                    )
                    ->colors([
                        'gray' => WorkOrderPriority::Low,
                        'info' => WorkOrderPriority::Medium,
                        'warning' => WorkOrderPriority::High,
                        'danger' => WorkOrderPriority::Critical,
                    ])
                    ->sortable(),

                TextColumn::make('scheduled_at')
                    ->label('Scheduled')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('due_at')
                    ->label('Due')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->stackedOnMobile()
            ->filters([
                SelectFilter::make('organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(
                        fn() => auth()->user()?->isAdmin()
                    ),

                SelectFilter::make('status')
                    ->options([
                        WorkOrderStatus::Draft->value => WorkOrderStatus::Draft->getLabel(),
                        WorkOrderStatus::Open->value => WorkOrderStatus::Open->getLabel(),
                        WorkOrderStatus::Assigned->value => WorkOrderStatus::Assigned->getLabel(),
                        WorkOrderStatus::InProgress->value => WorkOrderStatus::InProgress->getLabel(),
                        WorkOrderStatus::Completed->value => WorkOrderStatus::Completed->getLabel(),
                        WorkOrderStatus::Cancelled->value => WorkOrderStatus::Cancelled->getLabel(),
                    ]),

                SelectFilter::make('priority')
                    ->options([
                        WorkOrderPriority::Low->value => WorkOrderPriority::Low->getLabel(),
                        WorkOrderPriority::Medium->value => WorkOrderPriority::Medium->getLabel(),
                        WorkOrderPriority::High->value => WorkOrderPriority::High->getLabel(),
                        WorkOrderPriority::Critical->value => WorkOrderPriority::Critical->getLabel(),
                    ]),

                SelectFilter::make('customer')
                    ->relationship('customer', 'company_name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('location')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make()
                    ->disabled(
                        auth()->user()?->isTechnician()
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->disabled(
                            auth()->user()?->isTechnician()
                        ),
                ]),
            ]);
    }
}
