<?php

namespace App\Filament\Resources\WorkOrderComments\Pages;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkOrderComment extends ViewRecord
{
    protected static string $resource = WorkOrderCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
