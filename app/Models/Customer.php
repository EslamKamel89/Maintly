<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'organization_id',
    'company_name',
    'contact_person',
    'phone',
    'email',
    'notes',
])]
class Customer extends Model {
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;
    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }
    public function locations(): HasMany {
        return $this->hasMany(Location::class);
    }
    public function workOrders(): HasMany {
        return $this->hasMany(WorkOrder::class);
    }
}
