<?php

namespace App\Filament\Resources\WorkOrderAttachments\Pages;

use App\Filament\Resources\WorkOrderAttachments\WorkOrderAttachmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditWorkOrderAttachment extends EditRecord {
    protected static string $resource = WorkOrderAttachmentResource::class;

    protected function getHeaderActions(): array {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
