<?php

namespace App\Models;

use App\Enums\WorkOrderAttachmentType;
use App\Models\Concerns\HasOrganization;
use Database\Factories\WorkOrderAttachmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'organization_id',
    'work_order_id',
    'uploaded_by',
    'type',
    'notes',
    'path',
    'file_name',
    'mime_type',
    'file_size',
])]
class WorkOrderAttachment extends Model
{
    /** @use HasFactory<WorkOrderAttachmentFactory> */
    use HasFactory, HasOrganization;

    protected static function booted(): void
    {

        static::deleting(function (WorkOrderAttachment $attachment) {
            if ($attachment->path) {
                Storage::disk('public')->delete(
                    $attachment->path
                );
            }
        });
    }

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'type' => WorkOrderAttachmentType::class,
        ];
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
