<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Scopes;

use Atendwa\Msingi\Models\BaseUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Throwable;

class TenantVisibilityScope implements Scope
{
    /**
     * @param  Builder<Model>  $builder
     *
     * @throws Throwable
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (any([app()->runningInConsole(), auth()->guest()])) {
            return;
        }

        $tenantId = activeTenantID();
        $user = auth()->user();
        $column = 'tenant_id';

        if (! $user instanceof BaseUser) {
            return;
        }

        if (! $user->isSystemStaff()) {
            $builder->where($column, $tenantId);

            return;
        }

        $field = 'created_by';
        $column = 'status';

        $builder->withoutGlobalScopes()->where(function (Builder $builder) use ($field, $user, $column): void {
            $builder
                ->where(fn (Builder $query) => $builder->whereNot($column, 'draft'))
                ->orWhere($field, $user->getKey());
        });
    }
}
