<?php

namespace App\Models\Scopes;

use App\Context\OrganizationContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class OrganizationScope implements Scope {

    public function apply(Builder $builder, Model $model): void {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        if ($user->isAdmin()) {
            return;
        }

        $builder->where(
            $model->qualifyColumn('organization_id'),
            $user->organization_id,
        );
    }
}
