<?php

namespace App\Models\Concerns;

use App\Context\OrganizationContext;
use App\Models\Organization;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOrganization {

    protected static function bootHasOrganization(): void {
        static::addGlobalScope(new OrganizationScope);

        static::creating(function ($model) {
            if (
                $model->organization_id === null &&
                OrganizationContext::id() !== null
            ) {
                $model->organization_id = OrganizationContext::id();
            }
        });
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }
}
