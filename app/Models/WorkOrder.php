<?php

namespace App\Models;

use App\Enums\WorkOrderPriority;
use App\Enums\WorkOrderStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasOrganization;

#[Fillable([
    'organization_id',
    'customer_id',
    'location_id',
    'created_by',
    'title',
    'description',
    'status',
    'priority',
    'scheduled_at',
    'due_at',
    'started_at',
    'completed_at',
])]
class WorkOrder extends Model {
    /** @use HasFactory<\Database\Factories\WorkOrderFactory> */
    use HasFactory, HasOrganization;

    protected function casts(): array {
        return [
            'status' => WorkOrderStatus::class,
            'priority' => WorkOrderPriority::class,
            'scheduled_at' => 'datetime',
            'due_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }



    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }


    public function location(): BelongsTo {
        return $this->belongsTo(Location::class);
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assets(): BelongsToMany {
        return $this->belongsToMany(
            Asset::class,
            table: 'work_order_assets',
            foreignPivotKey: "work_order_id",
            relatedPivotKey: "asset_id",
        )->using(WorkOrderAsset::class)
            ->withTimestamps();
    }

    public function technicians(): BelongsToMany {
        return $this->belongsToMany(
            User::class,
            table: 'work_order_assignments',
            foreignPivotKey: "work_order_id",
            relatedPivotKey: "user_id",
        )
            ->using(WorkOrderAssignment::class)
            ->withPivot([
                'assigned_by',
                'assigned_at',
                'created_at',
                'updated_at',
            ]);
    }
    public function assignments(): HasMany {
        return $this->hasMany(WorkOrderAssignment::class);
    }

    public function comments(): HasMany {
        return $this->hasMany(WorkOrderComment::class);
    }

    public function attachments(): HasMany {
        return $this->hasMany(WorkOrderAttachment::class);
    }
}
