<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Throwable;

class TenantScope implements Scope
{
    /**
     * @param  Builder<Model>  $builder
     *
     * @throws Throwable
     */
    public function apply(Builder $builder, Model $model): void
    {
        $column = 'tenant_id';

        $builder->where($column, tenantId());
    }
}
