<?php

namespace App\Models\Scopes;

use App\Context\OrganizationContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class OrganizationScope implements Scope {

    public function apply(Builder $builder, Model $model): void {
        $organizationId = OrganizationContext::id();
        if ($organizationId == null) {
            return;
        }
        $builder->where(
            $model->qualifyColumn('organization_id'),
            $organizationId,
        );
    }
}
