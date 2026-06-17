<?php

namespace App\Filament\Resources\WorkOrderAttachments\Pages;

use App\Filament\Resources\WorkOrderAttachments\WorkOrderAttachmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkOrderAttachment extends ViewRecord
{
    protected static string $resource = WorkOrderAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
