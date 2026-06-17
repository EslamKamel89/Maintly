<?php

namespace App\Filament\Resources\WorkOrderComments\Pages;

use App\Filament\Resources\WorkOrderComments\WorkOrderCommentResource;
use App\Models\WorkOrder;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkOrderComment extends CreateRecord {
    protected static string $resource = WorkOrderCommentResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array {
        $workOrder = WorkOrder::findOrFail($data['work_order_id']);

        $data['user_id'] = auth()->id();
        $data['organization_id'] = $workOrder->organization_id;

        return $data;
    }
}
