<?php

namespace App\Filament\Resources\WorkOrderAttachments\Tables;

use App\Enums\WorkOrderAttachmentType;
use App\Models\WorkOrderAttachment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class WorkOrderAttachmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->visible(
                        fn () => auth()->user()?->isAdmin()
                    ),

                TextColumn::make('workOrder.title')
                    ->label('Work Order')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('uploader.name')
                    ->label('Uploaded By')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(
                        fn (WorkOrderAttachmentType $state) => $state->getLabel()
                    )
                    ->color(
                        fn (WorkOrderAttachmentType $state): string => match ($state) {
                            WorkOrderAttachmentType::Before => 'warning',
                            WorkOrderAttachmentType::After => 'success',
                            WorkOrderAttachmentType::General => 'gray',
                        }
                    )
                    ->sortable(),
                TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => Storage::url($record->path))
                    ->openUrlInNewTab(),

                TextColumn::make('mime_type')
                    ->label('File Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('file_size')
                    ->label('Size')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Uploaded')
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
                        fn () => auth()->user()?->isAdmin()
                    ),

                SelectFilter::make('workOrder')
                    ->relationship('workOrder', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('mime_type')
                    ->options(
                        fn () => WorkOrderAttachment::query()
                            ->distinct()
                            ->pluck('mime_type', 'mime_type')
                            ->toArray()
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(
                        fn ($record) => Storage::url($record->path)
                    )
                    ->openUrlInNewTab(),
                // EditAction::make()
                //     ->disabled(
                //         auth()->user()?->isTechnician()
                //     ),
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
