<?php

namespace App\Filament\Resources\WorkOrderComments\Pages;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkOrderComment extends CreateRecord
{
    protected static string $resource = WorkOrderCommentResource::class;
}
