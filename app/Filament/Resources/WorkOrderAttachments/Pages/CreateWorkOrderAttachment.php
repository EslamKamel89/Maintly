<?php

namespace App\Filament\Resources\WorkOrderAttachments\Pages;

use App\Filament\Resources\WorkOrderAttachments\WorkOrderAttachmentResource;
use App\Models\WorkOrder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateWorkOrderAttachment extends CreateRecord {
    protected static string $resource = WorkOrderAttachmentResource::class;
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array {
        $data['uploaded_by'] = auth()->id();
        $data['path'] = $data['attachment'];
        $workOrder = WorkOrder::findOrFail($data['work_order_id']);
        $data['organization_id'] = $workOrder->organization_id;
        $data['work_order_id'] = $workOrder->id;
        $data['file_name'] = basename($data['attachment']);
        $data['mime_type'] = Storage::disk('public')
            ->mimeType($data['path']);
        $data['file_size'] = Storage::disk('public')
            ->size($data['path']);
        unset($data['attachment']);
        return $data;
    }
}
