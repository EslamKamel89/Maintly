<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'organization_id',
    'work_order_id',
    'uploaded_by',
    'path',
    'file_name',
    'mime_type',
    'file_size',
])]
class WorkOrderAttachment extends Model {
    /** @use HasFactory<\Database\Factories\WorkOrderAttachmentFactory> */
    use HasFactory;

    protected function casts() {
        return [
            'file_size' => 'integer',
        ];
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function workOrder(): BelongsTo {
        return $this->belongsTo(WorkOrder::class);
    }

    public function uploader(): BelongsTo {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
