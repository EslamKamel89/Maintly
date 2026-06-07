<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'organization_id',
    'work_order_id',
    'user_id',
    'comment',
])]
class WorkOrderComment extends Model {
    /** @use HasFactory<\Database\Factories\WorkOrderCommentFactory> */
    use HasFactory;

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function workOrder(): BelongsTo {
        return $this->belongsTo(WorkOrder::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
