<?php

namespace App\Filament\Resources\WorkOrderComments\Pages;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkOrderComment extends EditRecord
{
    protected static string $resource = WorkOrderCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
