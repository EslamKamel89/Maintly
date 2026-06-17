<?php

namespace App\Filament\Resources\WorkOrderAttachments\Pages;

use App\Filament\Resources\WorkOrderAttachments\WorkOrderAttachmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrderAttachments extends ListRecords
{
    protected static string $resource = WorkOrderAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
