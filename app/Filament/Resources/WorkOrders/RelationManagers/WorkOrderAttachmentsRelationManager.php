<?php

namespace App\Filament\Resources\WorkOrders\RelationManagers;

use App\Filament\Resources\WorkOrderAttachments\WorkOrderAttachmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class WorkOrderAttachmentsRelationManager extends RelationManager {
    protected static string $relationship = 'attachments';

    protected static ?string $relatedResource = WorkOrderAttachmentResource::class;

    public function table(Table $table): Table {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
