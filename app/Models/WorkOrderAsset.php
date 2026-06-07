<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'work_order_id',
    'asset_id',
])]
class WorkOrderAsset extends Pivot {
    protected $table = 'work_order_assets';
    public $timestamps = true;

    public function workOrder(): BelongsTo {
        return $this->belongsTo(WorkOrder::class);
    }

    public function asset(): BelongsTo {
        return $this->belongsTo(Asset::class);
    }
}
