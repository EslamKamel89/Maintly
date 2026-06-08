<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Concerns\HasOrganization;

#[Fillable([
    'organization_id',
    'location_id',
    'name',
    'asset_code',
    'manufacturer',
    'model',
    'serial_number',
    'notes',
])]
class Asset extends Model {
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory, HasOrganization;



    public function location(): BelongsTo {
        return $this->belongsTo(Location::class);
    }

    public function workOrders(): BelongsToMany {
        return $this->belongsToMany(
            WorkOrder::class,
            'work_order_assets',
            foreignPivotKey: "asset_id",
            relatedPivotKey: "work_order_id",
        )->using(WorkOrderAsset::class)
            ->withTimestamps();
    }
}
