<?php

namespace App\Filament\Resources\WorkOrderAttachments\Schemas;

use App\Enums\WorkOrderAttachmentType;
use App\Models\WorkOrder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkOrderAttachmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Attachment Information')
                    ->schema([
                        Select::make('type')
                            ->options(WorkOrderAttachmentType::class)
                            ->default(WorkOrderAttachmentType::General)
                            ->required(),

                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('attachment')
                            ->label('Attachment')
                            ->disk('public')
                            ->directory(function (callable $get) {
                                $workOrder = WorkOrder::findOrFail($get('work_order_id'));

                                return sprintf(
                                    'organizations/%d/work-orders/%d',
                                    $workOrder->organization_id,
                                    $workOrder->id,
                                );
                            })
                            ->required()
                            ->downloadable()
                            ->openable(),
                        Hidden::make('work_order_id')
                            ->default(fn () => request()->route('work_order')),
                    ]),
            ])
            ->columns(1);
    }
}
