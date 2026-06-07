<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'work_order_id',
    'user_id',
    'assigned_by',
    'assigned_at',
])]
class WorkOrderAssignment extends Pivot {
    protected $table = 'work_order_assignments';
    public $timestamps = true;
    protected function casts(): array {
        return [
            'assigned_at' => 'datetime',

        ];
    }
    public function workOrder(): BelongsTo {
        return $this->belongsTo(WorkOrder::class);
    }

    public function technician(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
