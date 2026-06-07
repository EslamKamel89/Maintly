<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'organization_id',
    'customer_id',
    'name',
    'address',
    'city',
    'state',
    'latitude',
    'longitude',
    'notes',
])]
class Location extends Model {
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;
    protected function casts(): array {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }


    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function assets(): HasMany {
        return $this->hasMany(Asset::class);
    }

    public function workOrders(): HasMany {
        return $this->hasMany(WorkOrder::class);
    }
}
