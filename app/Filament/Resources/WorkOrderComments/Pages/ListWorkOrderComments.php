<?php

namespace App\Filament\Resources\WorkOrderComments\Pages;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkOrderComments extends ListRecords
{
    protected static string $resource = WorkOrderCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
